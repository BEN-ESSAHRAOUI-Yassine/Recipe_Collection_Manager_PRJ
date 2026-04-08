<?php
require_once __DIR__ . "/../core/database.php";

class Category {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

   public function categoryExist($name, $id = null) {
    if ($id) {
        $query = "SELECT COUNT(*) FROM categories WHERE name = ? AND id != ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$name, $id]);
    } else {
        $query = "SELECT COUNT(*) FROM categories WHERE name = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$name]);
    }

    return $stmt->fetchColumn() > 0;
}
    public function addCategory($name) {
        if ($this->categoryExist($name)) {
            return "exists";
        }
        $query = "INSERT INTO categories (name) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$name]);
    }

   public function getCategories() {
    $query = "SELECT * FROM categories";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result !== false ? $result : [];
}
     public function updateCategory($id, $name) {
        if ($this->categoryExist($name, $id)) {
            return "exists";
        }
        $query = "UPDATE categories SET name = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$name, $id]);
    }
    

   
}
?>