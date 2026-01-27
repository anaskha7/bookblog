<?php

class Comment
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO comments (post_id, user_id, body, rating, created_at) VALUES (:post_id, :user_id, :body, :rating, NOW())');
        $stmt->execute([
            ':post_id' => $data['post_id'],
            ':user_id' => $data['user_id'],
            ':body' => $data['body'],
            ':rating' => $data['rating'],
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function forPost(int $postId): array
    {
        $stmt = $this->db->prepare('SELECT comments.id, comments.post_id, comments.user_id, comments.body, comments.rating, comments.created_at, users.username FROM comments JOIN users ON users.id = comments.user_id WHERE comments.post_id = :post_id ORDER BY comments.created_at DESC');
        $stmt->execute([':post_id' => $postId]);
        return $stmt->fetchAll();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM comments WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT id, post_id, user_id, body, rating, created_at FROM comments WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $comment = $stmt->fetch();

        return $comment ?: null;
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT comments.id, comments.post_id, comments.user_id, comments.body, comments.rating, comments.created_at, users.username AS author, posts.title AS post_title FROM comments JOIN users ON users.id = comments.user_id JOIN posts ON posts.id = comments.post_id ORDER BY comments.created_at DESC');
        return $stmt->fetchAll();
    }

    public function averageRating(int $postId): float
    {
        $stmt = $this->db->prepare('SELECT AVG(rating) AS avg_rating FROM comments WHERE post_id = :post_id');
        $stmt->execute([':post_id' => $postId]);
        $row = $stmt->fetch();

        return (float) ($row['avg_rating'] ?? 0);
    }
}
