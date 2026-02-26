<?php

class BaseController
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Carga la vista (HTML) y le pasa los datos necesarios
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

    // Redirige al usuario a otra pagina
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    // Comprueba si el usuario esta logueado, sino lo manda al login
    protected function requireLogin(): void
    {
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/?controller=user&action=login');
        }
    }

    // Devuelve los datos del usuario que esta conectado ahora mismo
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

    // Comprueba si el usuario conectado es administrador
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

    // Guarda un mensaje temporal (como "Guardado con exito") para mostrarlo despues
    protected function setFlash(string $message, string $type = 'success'): void
    {
        $_SESSION['flash'] = ['message' => $message, 'type' => $type];
    }

    // Envia los datos a n8n para que mande el email automatico
    protected function triggerN8nWebhook(array $data): void
    {
        if (defined('N8N_WEBHOOK_URL') && filter_var(N8N_WEBHOOK_URL, FILTER_VALIDATE_URL)) {
            $ch = curl_init(N8N_WEBHOOK_URL);
            $payload = json_encode($data);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload)
            ]);
            // Espero poco tiempo para que la pagina no se quede colgada
            curl_setopt($ch, CURLOPT_TIMEOUT, 2);

            curl_exec($ch);
            curl_close($ch);
        }
    }

    // Crea un codigo secreto de seguridad CSRF
    protected function generateCsrf(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Comprueba que el codigo de seguridad CSRF sea correcto
    protected function verifyCsrf(?string $token): bool
    {
        if (empty($token) || empty($_SESSION['csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}
