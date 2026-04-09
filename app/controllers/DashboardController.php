<?php
class DashboardController extends BaseController {

    public function index() {
        Security::requireLogin();

        $role = $_SESSION['user']['role'];

        if ($role === 'admin') {

            //  Redirect admin to users dashboard (default page)
            header("Location: " . BASE_URL . "?url=admin/users");
            exit;

        } elseif ($role === 'chef') {

            //  Redirect recipe to index dashboard (default page)
            header("Location: " . BASE_URL . "?url=recipe/index");

        } else {

            // Optional: fallback if you have other roles
            header("Location: " . BASE_URL);
            exit;
        }
    }
}