<?php
class User
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function create(string $name, string $email, string $password, string $role = 'subscriber'): int
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        // Base de datos local usa 'username' y 'password_hash'
        $stmt = $this->db->prepare('INSERT INTO users (username, email, password_hash, role, created_at) VALUES (:name, :email, :password, :role, NOW())');
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $hash,
            ':role' => $role,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function findByEmail(string $email): ?array
    {
        // Alias de columnas para coincidir con lo que espera la app
        $stmt = $this->db->prepare('SELECT id, username as name, email, password_hash as password, role, created_at FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT id, username as name, email, password_hash as password, role, created_at FROM users WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function authenticate(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        if (!$user) {
            return null;
        }

        return password_verify($password, $user['password']) ? $user : null;
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT id, username as name, email, role, is_super, created_at FROM users ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public function updateRole(int $id, string $role): void
    {
        $stmt = $this->db->prepare('UPDATE users SET role = :role WHERE id = :id');
        $stmt->execute([':role' => $role, ':id' => $id]);
    }

    public function updateSuper(int $id, int $isSuper): void
    {
        $stmt = $this->db->prepare('UPDATE users SET is_super = :is_super WHERE id = :id');
        $stmt->execute([':is_super' => $isSuper, ':id' => $id]);
    }
}
