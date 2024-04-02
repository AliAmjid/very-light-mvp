<?php

namespace model;

use \PDO;

class AppRepository
{
    private \PDO $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function getCategoryById(int $categoryId): ?array
    {
        $query = $this->db->prepare('SELECT * FROM categories WHERE category_id=:category LIMIT 1;');
        $query->execute([
            ':category' => $categoryId
        ]);
        return $query->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getAllCategories(): array
    {
        $query = $this->db->prepare('SELECT * FROM categories ORDER BY name;');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertPost(int $userId, int $categoryId, string $text): void
    {
        $query = $this->db->prepare('INSERT INTO posts (user_id, category_id, text) VALUES (:user, :category, :text);');
        $query->execute([
            ':user' => $userId,
            ':category' => $categoryId,
            ':text' => $text
        ]);
    }

    public function updatePost(
        int    $postId,
        int    $userId,
        int    $categoryId,
        string $text
    ): void
    {
        $query = $this->db->prepare('UPDATE posts SET user_id = :user, category_id = :category, text = :text WHERE post_id = :post;');
        $query->execute([
            ':post' => $postId,
            ':user' => $userId,
            ':category' => $categoryId,
            ':text' => $text
        ]);
    }

    public function getAllPosts(): array
    {
        $query = $this->db->prepare('SELECT
                       posts.*, users.name AS user_name, users.email, categories.name AS category_name
                       FROM posts JOIN users USING (user_id) JOIN categories USING (category_id) ORDER BY updated DESC;');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPostById(int $postId): ?array
    {
        $query = $this->db->prepare('SELECT
                   posts.*, users.name AS user_name, users.email, categories.name AS category_name
                   FROM posts 
                   JOIN users USING (user_id) 
                   JOIN categories USING (category_id) 
                   WHERE posts.post_id = :post 
                   LIMIT 1;');
        $query->execute([
            ':post' => $postId
        ]);
        return $query->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getPostsByCategory(int $categoryId): array
    {
        $query = $this->db->prepare('SELECT
                   posts.*, users.name AS user_name, users.email, categories.name AS category_name
                   FROM posts
                   JOIN users USING (user_id)
                   JOIN categories USING (category_id)
                   WHERE categories.category_id = :category
                   ORDER BY updated DESC;');
        $query->execute([
            ':category' => $categoryId
        ]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}