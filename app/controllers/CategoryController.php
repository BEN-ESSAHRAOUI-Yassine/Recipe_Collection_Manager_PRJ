<?php
class CategoryController extends BaseController {
    private $CategoryM;

    public function __construct() {
        $this->CategoryM = new Category();
    }

    public function index() {
        $message      = $_SESSION['flash'] ?? '';
        $editCategory = null;
        $categories   = $this->CategoryM->getCategories();
        unset($_SESSION['flash']);
        $this->render('Category/list_category', compact('message', 'editCategory', 'categories'));
    }

    public function create() {
        $this->render('Category/add_category');
    }

    public function store() {
        $name   = htmlspecialchars(trim($_POST['name']));
        $result = $this->CategoryM->addCategory($name);
        $_SESSION['flash'] = ($result === "exists")
            ? "Cette categorie existe deja !"
            : "Categorie ajoutee avec succes !";
        header("Location: " . BASE_URL . "?url=category/index");
        exit;
    }

    public function edit($id) {
        $categories   = $this->CategoryM->getCategories();
        $editCategory = null;
        foreach ($categories as $cat) {
            if ((int)$cat['id'] === (int)$id) {
                $editCategory = $cat;
                break;
            }
        }
        $message = $_SESSION['flash'] ?? '';
        unset($_SESSION['flash']);
        $this->render('Category/list_category', compact('message', 'editCategory', 'categories'));
    }

    public function update($id) {
        $name   = htmlspecialchars(trim($_POST['name']));
        $result = $this->CategoryM->updateCategory($id, $name);
        $_SESSION['flash'] = ($result === "exists")
            ? "Cette catégorie existe déjà !"
            : "Catégorie mise à jour avec succès !";
        header("Location: " . BASE_URL . "?url=category/index");
        exit;
    }
}