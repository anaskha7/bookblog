<?php

class PostController extends BaseController
{
    private Post $postModel;
    private Comment $commentModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->postModel = new Post($db);
        $this->commentModel = new Comment($db);
    }

    public function index(): void
    {
        $posts = array_map(function ($post) {
            $post['avg_rating'] = $this->commentModel->averageRating((int) $post['id']);
            return $post;
        }, $this->postModel->all('published'));

        // Crear lista destacada (Top 3 por valoración)
        $featured = $posts;
        usort($featured, fn($a, $b) => $b['avg_rating'] <=> $a['avg_rating']);
        $featured = array_slice($featured, 0, 3);

        $this->render('posts/index', ['posts' => $posts, 'featured' => $featured]);
    }

    public function show(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $post = $this->postModel->find($id);
        if (!$post) {
            http_response_code(404);
            echo 'Post no encontrado';
            return;
        }

        // Comprobar visibilidad
        if (($post['status'] ?? 'published') === 'draft') {
            if (empty($_SESSION['user_id']) || (!$this->isAdmin() && $post['user_id'] !== $_SESSION['user_id'])) {
                http_response_code(404); // Ocultar borradores completamente
                echo 'Post no encontrado';
                return;
            }
        }

        $comments = $this->commentModel->forPost($id);
        $avgRating = $this->commentModel->averageRating($id);
        $this->render('posts/show', [
            'post' => $post,
            'comments' => $comments,
            'avgRating' => $avgRating,
        ]);
    }

    public function create(): void
    {
        $this->requireLogin();
        // Todos los usuarios logueados pueden crear posts ahora

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $imageFile = $_FILES['image'] ?? null;

            if ($title === '' || $content === '') {
                $errors[] = 'Completa todos los campos.';
            }

            if (!$imageFile || ($imageFile['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
                $errors[] = 'La portada es obligatoria.';
            }

            $imagePath = null;
            if (empty($errors) && $imageFile && ($imageFile['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
                $maxSize = 5 * 1024 * 1024;
                if ($imageFile['size'] > $maxSize) {
                    $errors[] = 'La portada no puede superar 5MB.';
                } else {
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mime = $finfo->file($imageFile['tmp_name']);
                    $allowed = [
                        'image/jpeg' => 'jpg',
                        'image/png' => 'png',
                        'image/webp' => 'webp',
                    ];

                    if (!isset($allowed[$mime])) {
                        $errors[] = 'Formato de imagen no permitido. Usa JPG, PNG o WEBP.';
                    } else {
                        $coversDir = __DIR__ . '/../public/covers';
                        if (!is_dir($coversDir)) {
                            mkdir($coversDir, 0755, true);
                        }
                        $filename = 'cover_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $allowed[$mime];
                        $destination = $coversDir . '/' . $filename;
                        if (!move_uploaded_file($imageFile['tmp_name'], $destination)) {
                            $errors[] = 'No se pudo guardar la portada. Inténtalo de nuevo.';
                        } else {
                            $imagePath = '/public/covers/' . $filename;
                        }
                    }
                }
            }

            if (empty($errors)) {
                $postId = $this->postModel->create([
                    'title' => $title,
                    'content' => $content,
                    'user_id' => $_SESSION['user_id'],
                    'image_url' => $imagePath,
                ]);

                WebhookClient::send('post_created', [
                    'id' => $postId,
                    'title' => $title,
                    'author_id' => $_SESSION['user_id'],
                ]);

                $this->redirect(BASE_URL . '?controller=post&action=show&id=' . $postId);
            }
        }

        $this->render('posts/create', ['errors' => $errors ?? []]);
    }

    public function edit(): void
    {
        $this->requireLogin();
        $id = (int) ($_GET['id'] ?? 0);
        $post = $this->postModel->find($id);
        if (!$post) {
            http_response_code(404);
            echo 'Post no encontrado';
            return;
        }

        if (!$this->isAdmin() && $post['user_id'] !== ($_SESSION['user_id'] ?? null)) {
            http_response_code(403);
            echo 'No puedes editar este post.';
            return;
        }

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');

            if ($title === '' || $content === '') {
                $errors[] = 'Completa todos los campos.';
            }

            if (empty($errors)) {
                $this->postModel->update($id, ['title' => $title, 'content' => $content]);
                $this->redirect(BASE_URL . '?controller=post&action=show&id=' . $id);
            }
        }

        $this->render('posts/edit', ['post' => $post, 'errors' => $errors]);
    }

    public function delete(): void
    {
        $this->requireLogin();
        $id = (int) ($_GET['id'] ?? 0);
        $post = $this->postModel->find($id);

        if (!$post) {
            http_response_code(404);
            echo 'Post no encontrado';
            return;
        }

        if (!$this->isAdmin() && $post['user_id'] !== ($_SESSION['user_id'] ?? null)) {
            http_response_code(403);
            echo 'No puedes borrar este post.';
            return;
        }

        $this->postModel->delete($id);
        $this->redirect(BASE_URL);
    }
}
