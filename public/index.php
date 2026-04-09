<?php

session_start();

/* ==============================
   CONSTANTS
============================== */
define('BASE_URL', '/Recipe_Collection_Manager_PRJ/public/');
define('ROOT', dirname(__DIR__));
define('APP',  ROOT . '/app');
define('VIEW', APP . '/views');

/* ==============================
   AUTOLOADER
============================== */
spl_autoload_register(function ($class) {
    $paths = [
        APP . '/models/',
        APP . '/controllers/',
        APP . '/core/',
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

/* ==============================
   GET & SANITIZE URL
============================== */
$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL) ?? 'dashboard';
$url = trim($url, '/');

$segments = explode('/', $url);
$segments[0] = $segments[0] ?: 'dashboard';

/* ==============================
   PUBLIC ROUTES
============================== */
$publicRoutes = ['login', 'register', 'do-login', 'do-register'];

if (!isset($_SESSION['user']) && !in_array($segments[0], $publicRoutes)) {
    header("Location: " . BASE_URL . "?url=login");
    exit;
}

/* ==============================
   HELPERS
============================== */
function requireMethod($method = 'GET')
{
    if ($_SERVER['REQUEST_METHOD'] !== $method) {
        http_response_code(405);
        exit('Method Not Allowed');
    }
}

function requireRole($role)
{
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== $role) {
        http_response_code(403);
        echo "403 - Forbidden";
        exit;
    }
}

/* ==============================
   ROUTING
============================== */
switch ($segments[0]) {

    /* ---------- AUTH ---------- */
    case 'login':
        requireMethod('GET');
        (new AuthController())->showLogin();
        break;

    case 'register':
        requireMethod('GET');
        (new AuthController())->showRegister();
        break;

    case 'do-login':
        requireMethod('POST');
        (new AuthController())->login();
        break;

    case 'do-register':
        requireMethod('POST');
        (new AuthController())->register();
        break;

    case 'logout':
        session_destroy();
        header("Location: " . BASE_URL . "?url=login");
        exit;

    /* ---------- DASHBOARD ---------- */
    case 'dashboard':
        (new DashboardController())->index();
        break;

    /* ---------- ADMIN ---------- */
    case 'admin':
        requireRole('admin');

        $controller = new AdminController();
        $action = $segments[1] ?? 'users';
        $id = $segments[2] ?? null;

        switch ($action) {
            case 'users':
                $controller->users();
                break;

            case 'create-user':
                requireMethod('GET');
                $controller->createUserform();
                break;

            case 'store-user':
                requireMethod('POST');
                $controller->storeUserform();
                break;

            case 'edit-user':
                $controller->editUserform($id);
                break;

            case 'update-user':
                requireMethod('POST');
                $controller->updateUserform($id);
                break;

            case 'delete-user':
                requireMethod('POST');
                $controller->deleteUserform($id);
                break;

            default:
                header("Location: " . BASE_URL . "?url=dashboard");
                exit;
        }
        break;

    /* ---------- RECIPES ---------- */
    case 'recipe':
        $controller = new RecipeController();
        $action = $segments[1] ?? 'index';
        $id = $segments[2] ?? null;

        switch ($action) {
            case 'index':
                $controller->index();
                break;

            case 'create':
                requireMethod('GET');
                $controller->create();
                break;

            case 'store':
                requireMethod('POST');
                $controller->store();
                break;

            case 'edit':
                $controller->edit($id);
                break;

            case 'update':
                requireMethod('POST');
                $controller->update($id);
                break;

            case 'delete':
                requireMethod('POST');
                $controller->delete($id);
                break;

            default:
                header("Location: " . BASE_URL . "?url=recipe/index");
                exit;
        }
        break;

    /* ---------- CATEGORIES ---------- */
    case 'category':
        $controller = new CategoryController();
        $action = $segments[1] ?? 'index';
        $id = $segments[2] ?? null;

        switch ($action) {
            case 'index':
                $controller->index();
                break;

            case 'create':
                requireMethod('GET');
                $controller->create();
                break;

            case 'store':
                requireMethod('POST');
                $controller->store();
                break;

            case 'edit':
                $controller->edit($id);
                break;

            case 'update':
                requireMethod('POST');
                $controller->update($id);
                break;

            default:
                header("Location: " . BASE_URL . "?url=category/index");
                exit;
        }
        break;
    
    case 'favorite':
        $controller = new FavoriteController();
        $action = $segments[1] ?? 'index';
        $id = $segments[2] ?? null;

        switch ($action) {
            case 'index':
                $controller->index();
                break;
            case 'add':
                $controller->add($id);
                break;
            case 'remove':
                $controller->remove($id);
                break;
            
            default:
                header("Location: " . BASE_URL . "?url=recipe/index");
                exit;
        }
        break;
    /* ---------- 404 ---------- */
    default:
        http_response_code(404);

        echo "<div style='text-align:center; padding:60px; font-family:sans-serif;'>
                    <h2>404 — Page not found</h2>
                    <a href='" . BASE_URL . "?url=dashboard'>Go to Dashboard</a>
                  </div>";
        
        break;
}