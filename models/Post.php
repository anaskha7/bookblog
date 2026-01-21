<?php

class Post
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function all(?string $status = null): array
    {
        $sql = 'SELECT posts.*, users.username AS author, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comment_count FROM posts JOIN users ON users.id = posts.user_id';
        if ($status) {
            $sql .= " WHERE posts.status = '$status'";
        }
        $sql .= ' ORDER BY posts.created_at DESC';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT posts.*, users.username AS author FROM posts JOIN users ON users.id = posts.user_id WHERE posts.id = :id');
        $stmt->execute([':id' => $id]);
        $post = $stmt->fetch();

        return $post ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO posts (title, content, user_id, image_url, status, created_at, updated_at) VALUES (:title, :content, :user_id, :image_url, :status, NOW(), NOW())');
        $stmt->execute([
            ':title' => $data['title'],
            ':content' => $data['content'],
            ':user_id' => $data['user_id'],
            ':image_url' => $data['image_url'],
            ':status' => $data['status'] ?? 'published',
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $fields = ['title', 'content'];
        $params = [
            ':title' => $data['title'],
            ':content' => $data['content'],
            ':id' => $id,
        ];

        if (isset($data['status'])) {
            $fields[] = 'status';
            $params[':status'] = $data['status'];
            $sql = 'UPDATE posts SET title = :title, content = :content, status = :status, updated_at = NOW() WHERE id = :id';
        } else {
            $sql = 'UPDATE posts SET title = :title, content = :content, updated_at = NOW() WHERE id = :id';
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
    }

    public function updateStatus(int $id, string $status): void
    {
        $stmt = $this->db->prepare('UPDATE posts SET status = :status, updated_at = NOW() WHERE id = :id');
        $stmt->execute([':status' => $status, ':id' => $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM posts WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    public function searchFullText(string $query): array
    {
        $stmt = $this->db->prepare("SELECT id, title, content, MATCH(title, content) AGAINST (:query IN NATURAL LANGUAGE MODE) AS score FROM posts WHERE status = 'published' AND MATCH(title, content) AGAINST (:query IN NATURAL LANGUAGE MODE) ORDER BY score DESC LIMIT 5");
        $stmt->execute([':query' => $query]);
        return $stmt->fetchAll();
    }

    public function searchByAuthor(string $name): array
    {
        // Buscar posts cuyo nombre de autor coincida con la consulta (coincidencia parcial)
        $stmt = $this->db->prepare("SELECT posts.*, users.username AS author FROM posts JOIN users ON users.id = posts.user_id WHERE posts.status = 'published' AND users.username LIKE :name ORDER BY posts.created_at DESC");
        $stmt->execute([':name' => "%{$name}%"]);
        return $stmt->fetchAll();
    }
}
