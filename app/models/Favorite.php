<?php

class Favorite {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function add($userId, $recipeId) {
        $stmt = $this->db->prepare(
            "INSERT IGNORE INTO favorites (id_user, id_recipe) VALUES (?, ?)"
        );
        return $stmt->execute([$userId, $recipeId]);
    }

    public function remove($userId, $recipeId) {
        $stmt = $this->db->prepare(
            "DELETE FROM favorites WHERE id_user=? AND id_recipe=?"
        );
        return $stmt->execute([$userId, $recipeId]);
    }

    public function getByUser($userId) {
        $stmt = $this->db->prepare("
            SELECT r.* FROM favorites f
            JOIN recipes r ON f.id_recipe = r.id
            WHERE f.id_user=?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
