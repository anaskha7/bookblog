<?php

class CommentController extends BaseController
{
    private Comment $commentModel;
    private Post $postModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->commentModel = new Comment($db);
        $this->postModel = new Post($db);
    }

    public function store(): void
    {
        $this->requireLogin();
        // Cualquier usuario logueado puede crear valoraciones/comentarios
        $errors = [];
        $postId = (int) ($_POST['post_id'] ?? 0);
        $body = trim($_POST['body'] ?? '');
        $rating = (int) ($_POST['rating'] ?? 0);

        if (!$this->postModel->find($postId)) {
            http_response_code(404);
            echo 'Post no encontrado';
            return;
        }

        if ($body === '' || $rating < 0 || $rating > 5) {
            $errors[] = 'Comentario o rating inválido.';
        }

        if (empty($errors)) {
            $commentId = $this->commentModel->create([
                'post_id' => $postId,
                'user_id' => $_SESSION['user_id'],
                'body' => $body,
                'rating' => $rating,
            ]);

            WebhookClient::send('comment_created', [
                'id' => $commentId,
                'post_id' => $postId,
                'user_id' => $_SESSION['user_id'],
                'rating' => $rating,
            ]);
        }

        $this->redirect(BASE_URL . '?controller=post&action=show&id=' . $postId);
    }

    public function delete(): void
    {
        $this->requireLogin();
        $commentId = (int) ($_GET['id'] ?? 0);
        $comment = $this->commentModel->find($commentId);
        if (!$comment) {
            http_response_code(404);
            echo 'Comentario no encontrado';
            return;
        }

        if (!$this->isAdmin() && $comment['user_id'] !== ($_SESSION['user_id'] ?? null)) {
            http_response_code(403);
            echo 'No puedes borrar este comentario.';
            return;
        }

        $this->commentModel->delete($commentId);

        WebhookClient::send('comment_deleted', [
            'id' => $commentId,
            'post_id' => $comment['post_id'],
            'user_id' => $comment['user_id'],
        ]);

        $this->redirect(BASE_URL . '?controller=post&action=show&id=' . $comment['post_id']);
    }
}
