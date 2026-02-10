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

        $updates = ['title = :title', 'content = :content'];

        if (isset($data['status'])) {
            $updates[] = 'status = :status';
            $params[':status'] = $data['status'];
        }

        if (isset($data['image_url'])) {
            $updates[] = 'image_url = :image_url';
            $params[':image_url'] = $data['image_url'];
        }

        $updates[] = 'updated_at = NOW()';

        $sql = 'UPDATE posts SET ' . implode(', ', $updates) . ' WHERE id = :id';

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

    public function getRelated(int $id, string $title, string $content, int $limit = 3): array
    {
        // RAG-lite: Búsqueda basada en contenido usando MATCH AGAINST
        // Excluimos el post actual
        $query = $title . ' ' . substr($content, 0, 100); // Usamos titulo y primeros 100 chars

        // Primero intentamos búsqueda fulltext
        try {
            $stmt = $this->db->prepare("
                SELECT posts.*, users.username AS author, 
                MATCH(title, content) AGAINST (:query IN NATURAL LANGUAGE MODE) AS score 
                FROM posts 
                JOIN users ON users.id = posts.user_id
                WHERE posts.status = 'published' 
                AND posts.id != :id
                HAVING score > 0
                ORDER BY score DESC 
                LIMIT :limit
            ");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':query', $query);
            $stmt->execute();
            $results = $stmt->fetchAll();

            if (!empty($results)) {
                return $results;
            }
        } catch (PDOException $e) {
            // Si falla (por ejemplo si no hay índice FullText), fallback a recientes
        }

        // Fallback: Posts más recientes que no sean este
        $stmt = $this->db->prepare("
            SELECT posts.*, users.username AS author 
            FROM posts 
            JOIN users ON users.id = posts.user_id
            WHERE posts.status = 'published' AND posts.id != :id 
            ORDER BY created_at DESC 
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
