<?php
class UserController extends BaseController
{
    private User $userModel;

    public function __construct(PDO $db)
    {
        parent::__construct($db);
        $this->userModel = new User($db);
    }

    public function register(): void
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = 'subscriber';

            if ($name === '' || $email === '' || $password === '') {
                $errors[] = 'Completa todos los campos obligatorios.';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Correo inválido.';
            }

            if ($this->userModel->findByEmail($email)) {
                $errors[] = 'Ya existe un usuario con ese email.';
            }

            // el código secreto ya no se muestra en la página de registro; mantener soporte si se envía
            if (!empty($_POST['secret_code']) && $_POST['secret_code'] === ADMIN_SECRET_CODE) {
                $role = 'admin';
            }

            if (empty($errors)) {
                $userId = $this->userModel->create($name, $email, $password, $role);

                // Si se crea como admin vía código secreto, hacerlo super admin
                if ($role === 'admin') {
                    $this->userModel->updateSuper($userId, 1);
                }

                $_SESSION['user_id'] = $userId;
                $_SESSION['role'] = $role;
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['is_super'] = ($role === 'admin') ? 1 : 0;
                $this->redirect(BASE_URL);
            }
        }

        $this->render('auth/register', ['errors' => $errors ?? []]);
    }

    public function login(): void
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->authenticate($email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['is_super'] = (int) ($user['is_super'] ?? 0);
                $this->redirect(BASE_URL);
            } else {
                $errors[] = 'Credenciales incorrectas.';
            }
        }

        $this->render('auth/login', ['errors' => $errors]);
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect(BASE_URL);
    }

    public function upgrade(): void
    {
        // acción upgrade eliminada: código admin solo se usa en el registro
        http_response_code(404);
        echo 'Página no disponible';
    }
}
