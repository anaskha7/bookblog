<?php

class BaseController
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    protected function render(string $view, array $data = []): void
    {
        extract($data);
        $viewPath = __DIR__ . '/../views/' . $view . '.php';
        if (!file_exists($viewPath)) {
            http_response_code(404);
            echo 'Vista no encontrada';
            return;
        }

        include __DIR__ . '/../views/layout/header.php';
        include $viewPath;
        include __DIR__ . '/../views/layout/footer.php';
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    protected function requireLogin(): void
    {
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/?controller=user&action=login');
        }
    }

    protected function currentUser(): ?array
    {
        if (empty($_SESSION['user_id'])) {
            return null;
        }

        return [
            'id' => $_SESSION['user_id'],
            'role' => $_SESSION['role'] ?? 'subscriber',
            'name' => $_SESSION['name'] ?? '',
            'email' => $_SESSION['email'] ?? '',
            'is_super' => $_SESSION['is_super'] ?? 0,
        ];
    }

    protected function isAdmin(): bool
    {
        return ($this->currentUser()['role'] ?? '') === 'admin';
    }

    protected function isSuper(): bool
    {
        return (int) ($this->currentUser()['is_super'] ?? 0) === 1;
    }

    protected function isWriterOrAdmin(): bool
    {
        $role = $this->currentUser()['role'] ?? '';
        return in_array($role, ['admin', 'writer'], true);
    }
}
