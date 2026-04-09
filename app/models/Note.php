<?php

class Note {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function addOrUpdate($userId, $recipeId, $note, $rating) {
        $stmt = $this->db->prepare("
            INSERT INTO notes (id_user, id_recipe, note, rating)
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE note=?, rating=?
        ");
        return $stmt->execute([$userId, $recipeId, $note, $rating, $note, $rating]);
    }

    public function getByUser($userId) {
        $stmt = $this->db->prepare("
            SELECT n.*, r.title FROM notes n
            JOIN recipes r ON n.id_recipe = r.id
            WHERE n.id_user=?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}