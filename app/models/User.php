<?php

class User {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }


    // Find user by email
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Find user by ID 
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([(int)$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($name, $email, $password, $role) {
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $role]);
        return $this->db->lastInsertId();
    }

    public function updateUser($id, $name, $email, $role) {
        $stmt = $this->db->prepare("
            UPDATE users SET username=?, email=?, role=? WHERE id=?
        ");
        return $stmt->execute([$name, $email, $role, (int)$id]);
    }

    public function deleteUser($id) {
    $stmt = $this->db->prepare("DELETE FROM users WHERE id=?");
    return $stmt->execute([(int)$id]);
    }

    public function isAdmin($id) {
    $stmt = $this->db->prepare("SELECT role FROM users WHERE id=?");
    $stmt->execute([(int)$id]);
    $role = $stmt->fetchColumn();

    return $role === 'admin';
    }

    // Update profile name only
    public function updateName($id, $name) {
        $stmt = $this->db->prepare("UPDATE users SET username=? WHERE id=?");
        return $stmt->execute([$name, (int)$id]);
    }

    // Update profile name + password
    public function updateWithPassword($id, $name, $hashedPassword) {
        $stmt = $this->db->prepare("UPDATE users SET username=?, password=? WHERE id=?");
        return $stmt->execute([$name, $hashedPassword, (int)$id]);
    }

    // Check if any admin exists (used on first register)
    public function adminExists() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM users WHERE role='admin'");
        return $stmt->fetchColumn() > 0;
    }

    // Get all users with optional search and sort
    public function getAllUsers($search = '', $sort = 'id', $order = 'ASC', $limit = 50, $offset = 0) {

        // Only allow safe sort columns
        $sortMap = [
            'id' => 'id',
            'username'    => 'username',
            'email'   => 'email',
            'role'    => 'role',
            'created_at' => 'created_at',
        ];

        $sort  = $sortMap[$sort]  ?? 'id';
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';

        $sql = "SELECT * FROM users WHERE 1";

        if ($search) {
            $sql .= " AND (username LIKE :search OR email LIKE :search)";
        }

        $sql .= " ORDER BY $sort $order LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        if ($search) {
            $stmt->bindValue(':search', "%$search%");
        }

        $stmt->bindValue(':limit',  (int)$limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}