<?php
class RecipeController extends BaseController {
    private $recipeModel;
    private $categoryModel;

    public function __construct() {
        $this->recipeModel   = new Recipe();
        $this->categoryModel = new Category();
    }

  public function index() {
    $id_user  = $_SESSION['user']['id'];
    $search   = trim($_GET['search']   ?? '');
    $category = trim($_GET['category'] ?? '');

    $recipes    = $this->recipeModel->searchRecipes($id_user, $search, $category);
    $uniqueCats = $this->categoryModel->getCategories();

    $message = $_SESSION['flash'] ?? '';
    unset($_SESSION['flash']);

    $this->render('Recipe/list_recipe', compact('recipes', 'uniqueCats', 'search', 'category', 'message'));
}

    public function create() {
        $categories = $this->categoryModel->getCategories();
        $this->render('Recipe/add_recipe', compact('categories'));
    }

    public function store() {
        $data = [
            'title'        => htmlspecialchars(trim($_POST['title'])),
            'ingredients'  => htmlspecialchars(trim($_POST['ingredients'])),
            'instructions' => htmlspecialchars(trim($_POST['instructions'])),
            'prep_time'    => (int)$_POST['prep_time'],
            'portions'     => htmlspecialchars(trim($_POST['portions'])),
            'id_category'  => (int)$_POST['id_category'],
            'id_user'      => $_SESSION['user']['id'],
        ];
        $this->recipeModel->addRecipe($data);
        $_SESSION['flash'] = "Recette ajoutée avec succès !";
        header("Location: " . BASE_URL . "?url=recipe/index");
        exit;
    }

    public function edit($id) {
        $recipe     = $this->recipeModel->getRecipeById($id);
        $categories = $this->categoryModel->getCategories();
        $message    = '';
        $this->render('Recipe/edit_recipe', compact('recipe', 'categories', 'message'));
    }

    public function update($id) {
        $data = [
            'title'        => htmlspecialchars(trim($_POST['title'])),
            'ingredients'  => htmlspecialchars(trim($_POST['ingredients'])),
            'instructions' => htmlspecialchars(trim($_POST['instructions'])),
            'prep_time'    => (int)$_POST['prep_time'],
            'portions'     => htmlspecialchars(trim($_POST['portions'])),
            'id_category'  => (int)$_POST['id_category'],
        ];
        $this->recipeModel->updateRecipe($id, $data);
        $_SESSION['flash'] = "Recette mise à jour avec succès !";
        header("Location: " . BASE_URL . "?url=recipe/index");
        exit;
    }

    public function delete($id) {
        $this->recipeModel->deleteRecipe($id);
        $_SESSION['flash'] = "Recette supprimée avec succès !";
        header("Location: " . BASE_URL . "?url=recipe/index");
        exit;
    }
    public function show($id) {
    $recipe = $this->recipeModel->getRecipeById($id);
    if (!$recipe) {
        $_SESSION['flash'] = "Recette introuvable.";
        header("Location: " . BASE_URL . "?url=recipe/index");
        exit;
    }
    $this->render('Recipe/show_recipe', compact('recipe'));
}
}