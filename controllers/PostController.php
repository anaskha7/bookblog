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

        // RAG/Relacionados
        $relatedPosts = $this->postModel->getRelated($id, $post['title'], $post['content']);

        $this->render('posts/show', [
            'post' => $post,
            'comments' => $comments,
            'avgRating' => $avgRating,
            'relatedPosts' => $relatedPosts
        ]);
    }

    private function handleFileUpload(?array $file, array &$errors): ?string
    {
        ini_set('memory_limit', '256M'); // Aumentar memoria para imágenes grandes
        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            $errors[] = 'Error al subir el archivo.';
            return null;
        }

        $maxSize = 64 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            $errors[] = 'La portada no puede superar 64MB.';
            return null;
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ];

        if (!isset($allowed[$mime])) {
            $errors[] = 'Formato de imagen no permitido. Usa JPG, PNG o WEBP.';
            return null;
        }

        $uploadsDir = __DIR__ . '/../public/uploads';
        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0755, true);
        }

        $filename = 'cover_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $allowed[$mime];
        $destination = $uploadsDir . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            $errors[] = 'No se pudo guardar la portada. Inténtalo de nuevo.';
            return null;
        }

        return '/public/uploads/' . $filename;
    }

    public function create(): void
    {
        $this->requireLogin();

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');

            if ($title === '' || $content === '') {
                $errors[] = 'Completa todos los campos.';
            }

            $imagePath = $this->handleFileUpload($_FILES['image'] ?? null, $errors);

            if (!$imagePath && empty($errors)) {
                $errors[] = 'La portada es obligatoria.';
            }

            if (empty($errors)) {
                $postId = $this->postModel->create([
                    'title' => $title,
                    'content' => $content,
                    'user_id' => $_SESSION['user_id'],
                    'image_url' => $imagePath,
                ]);



                // Integración n8n: Enviar notificación
                $this->triggerN8nWebhook([
                    'event' => 'new_post',
                    'post_id' => $postId,
                    'title' => $title,
                    'summary' => substr($content, 0, 200) . '...',
                    'author_id' => $_SESSION['user_id'],
                    'image_url' => $imagePath ? (BASE_URL . $imagePath) : null,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $this->setFlash('¡Reseña publicada con éxito! Gracias por compartir.');
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

            $imagePath = $this->handleFileUpload($_FILES['image'] ?? null, $errors);

            if (empty($errors)) {
                $updateData = ['title' => $title, 'content' => $content];
                if ($imagePath) {
                    $updateData['image_url'] = $imagePath;
                }

                $this->postModel->update($id, $updateData);
                $this->setFlash('La reseña se ha actualizado correctamente.');
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
        $this->setFlash('La reseña ha sido eliminada.');
        $this->redirect(BASE_URL);
    }
}
