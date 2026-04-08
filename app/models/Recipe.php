<?php
require_once __DIR__ . "/../core/database.php";

class Recipe {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function addRecipe($data) {
        $query = "INSERT INTO recipes 
            (title, ingredients, instructions, prep_time, portions, id_category, id_user) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['title'],
            $data['ingredients'],
            $data['instructions'],
            $data['prep_time'],
            $data['portions'],
            $data['id_category'],
            $data['id_user']
        ]);
    }

    public function getRecipesByUser($id_user) {
        $query = "SELECT r.*, c.name AS category_name 
                  FROM recipes r
                  LEFT JOIN categories c ON r.id_category = c.id
                  WHERE r.id_user = ?
                  ORDER BY r.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id_user]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecipeById($id) {
        $query = "SELECT * FROM recipes WHERE id_recipe = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateRecipe($id, $data) {
        $query = "UPDATE recipes SET title = ?, ingredients = ?, instructions = ?, prep_time = ?, portions = ?, id_category = ? WHERE id_recipe = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['title'],
            $data['ingredients'],
            $data['instructions'],
            $data['prep_time'],
            $data['portions'],
            $data['id_category'],
            $id
        ]);
    }

    public function deleteRecipe($id) {
        $query = "DELETE FROM recipes WHERE id_recipe = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>