<?php

class AdminController extends BaseController {

    // Constructor: every admin action requires admin role
    public function __construct() {
        Security::requireRole('admin');
    }

    // List all users with search and sort
    public function users() {
        $search = $_GET['search'] ?? '';
        $sort   = $_GET['sort']   ?? 'id';
        $order  = $_GET['order']  ?? 'ASC';

        $users = (new User())->getAllUsers($search, $sort, $order);

        $this->render('admin/users', compact('users', 'search', 'sort', 'order'));
    }

    // Show create user form
    public function createUserform() {
        $this->render('admin/user_form');
    }

    // Save new user
    public function storeUserform() {
        if (!Security::verifyCsrf($_POST['csrf'] ?? '')) {
            Security::setFlash('error', 'Security check failed.');
            header("Location: " . BASE_URL . "?url=admin/create-user");
            exit;
        }

        $name   = Security::sanitize($_POST['name']  ?? '');
        $email  = Security::sanitize($_POST['email'] ?? '');
        $pass   = $_POST['password'] ?? '';

        // Whitelist allowed roles — SECURITY FIX
        $allowedRoles = ['admin', 'chef'];
        $role = in_array($_POST['role'] ?? '', $allowedRoles) ? $_POST['role'] : 'chef';

        if (empty($name) || empty($email) || empty($pass)) {
            Security::setFlash('error', 'Please fill in all fields.');
            header("Location: " . BASE_URL . "?url=admin/create-user");
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Security::setFlash('error', 'Invalid email address.');
            header("Location: " . BASE_URL . "?url=admin/create-user");
            exit;
        }

        $userModel = new User();

        if ($userModel->findByEmail($email)) {
            Security::setFlash('error', 'Email already exists.');
            header("Location: " . BASE_URL . "?url=admin/create-user");
            exit;
        }

        $id = $userModel->createUser($name, $email, password_hash($pass, PASSWORD_DEFAULT), $role);

        Security::setFlash('success', 'User created successfully.');
        header("Location: " . BASE_URL . "?url=admin/users");
        exit;
    }

    // Show edit user form
    public function editUserform() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            Security::setFlash('error', 'Invalid user.');
            header("Location: " . BASE_URL . "?url=admin/users");
            exit;
        }

        $user = (new User())->findById($id);

        if (!$user) {
            Security::setFlash('error', 'User not found.');
            header("Location: " . BASE_URL . "?url=admin/users");
            exit;
        }

        $this->render('admin/user_form', compact('user'));
    }

    // Save updated user
    public function updateUserform() {
        if (!Security::verifyCsrf($_POST['csrf'] ?? '')) {
            Security::setFlash('error', 'Security check failed.');
            header("Location: " . BASE_URL . "?url=admin/users");
            exit;
        }

        $id    = (int)($_POST['id_user'] ?? 0);
        $name  = Security::sanitize($_POST['name']  ?? '');
        $email = Security::sanitize($_POST['email'] ?? '');

        // Whitelist roles — SECURITY FIX
        $allowedRoles    = ['admin', 'chef'];
        $role   = in_array($_POST['role']   ?? '', $allowedRoles)    ? $_POST['role']   : 'chef';

        if ($id <= 0 || empty($name) || empty($email)) {
            Security::setFlash('error', 'Please fill in all fields.');
            header("Location: " . BASE_URL . "?url=admin/users");
            exit;
        }

        (new User())->updateUser($id, $name, $email, $role);

        Security::setFlash('success', 'User updated successfully.');
        header("Location: " . BASE_URL . "?url=admin/users");
        exit;
    }

    public function deleteUser() {

        // CSRF protection
        if (!Security::verifyCsrf($_POST['csrf'] ?? '')) {
            Security::setFlash('error', 'Security check failed.');
            header("Location: " . BASE_URL . "?url=admin/users");
            exit;
        }

        $id = (int)($_POST['id_user'] ?? 0);

        if ($id <= 0) {
            Security::setFlash('error', 'Invalid user.');
            header("Location: " . BASE_URL . "?url=admin/users");
            exit;
        }

        // ❌ Prevent admin from deleting himself
        if ($id === $_SESSION['user']['id_user']) {
            Security::setFlash('error', 'You cannot delete your own account.');
            header("Location: " . BASE_URL . "?url=admin/users");
            exit;
        }

        //  Optional (recommended): prevent deleting other admins
        if ((new User())->isAdmin($id)) {
            Security::setFlash('error', 'You cannot delete another admin.');
            header("Location: " . BASE_URL . "?url=admin/users");
            exit;
        }

        (new User())->deleteUser($id);

        Security::setFlash('success', 'User deleted successfully.');
        header("Location: " . BASE_URL . "?url=admin/users");
        exit;
    }
}