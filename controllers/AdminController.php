<?php

class AdminController extends BaseController
{
    private User $userModel;
    private Post $postModel;
    private Comment $commentModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->userModel = new User($db);
        $this->postModel = new Post($db);
        $this->commentModel = new Comment($db);
    }

    private function requireAdmin(): void
    {
        $this->requireLogin();
        if (!$this->isAdmin()) {
            http_response_code(403);
            echo 'Solo admins.';
            exit;
        }
    }

    public function dashboard(): void
    {
        $this->requireAdmin();
        $stats = [
            'users' => (int) $this->db->query('SELECT COUNT(*) FROM users')->fetchColumn(),
            'posts' => (int) $this->db->query('SELECT COUNT(*) FROM posts')->fetchColumn(),
            'comments' => (int) $this->db->query('SELECT COUNT(*) FROM comments')->fetchColumn(),
        ];

        $this->render('admin/dashboard', ['stats' => $stats]);
    }

    public function users(): void
    {
        $this->requireAdmin();

        // Only superadmin can manage users
        if (!$this->isSuper()) {
            http_response_code(403);
            echo 'Solo el superadmin puede gestionar usuarios.';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = (int) ($_POST['user_id'] ?? 0);
            $role = $_POST['role'] ?? 'subscriber';
            $isSuper = isset($_POST['is_super']) ? 1 : 0;
            $this->userModel->updateRole($userId, $role);
            $this->userModel->updateSuper($userId, $isSuper);
        }

        $users = $this->userModel->all();
        $this->render('admin/users', ['users' => $users]);
    }

    public function toggle_status(): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postId = (int) ($_POST['post_id'] ?? 0);
            $newStatus = $_POST['status'] ?? 'published';

            if (in_array($newStatus, ['draft', 'published'])) {
                $this->postModel->updateStatus($postId, $newStatus);
            }
        }

        $this->redirect(BASE_URL . '?controller=admin&action=posts');
    }

    public function posts(): void
    {
        $this->requireAdmin();
        $posts = $this->postModel->all();
        $this->render('admin/posts', ['posts' => $posts]);
    }

    public function comments(): void
    {
        $this->requireAdmin();
        $comments = $this->commentModel->all();
        $this->render('admin/comments', ['comments' => $comments]);
    }
}
