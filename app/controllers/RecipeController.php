<?php


class RecipeController {
    private $recipeModel;
    private $categoryModel;

    public function __construct() {
        $this->recipeModel = new Recipe();
        $this->categoryModel = new Category();
    }

    public function listRecipes($id_user) {
        $recipes = $this->recipeModel->getRecipesByUser($id_user);
        include __DIR__ . "/../views/Recipe/list_recipes.php";
    }

    public function addRecipe($id_user) {
        $categories = $this->categoryModel->getCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'ingredients' => $_POST['ingredients'],
                'instructions' => $_POST['instructions'],
                'prep_time' => $_POST['prep_time'],
                'portions' => $_POST['portions'],
                'id_category' => $_POST['id_category'],
                'id_user' => $id_user
            ];
            $this->recipeModel->addRecipe($data);
            header("Location: list_recipes.php");
        }

        include __DIR__ . "/../views/Recipe/add_recipe.php";
    }

    public function editRecipe($id_recipe) {
        $recipe = $this->recipeModel->getRecipeById($id_recipe);
        $categories = $this->categoryModel->getCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'ingredients' => $_POST['ingredients'],
                'instructions' => $_POST['instructions'],
                'prep_time' => $_POST['prep_time'],
                'portions' => $_POST['portions'],
                'id_category' => $_POST['id_category']
            ];
            $this->recipeModel->updateRecipe($id_recipe, $data);
            header("Location: list_recipes.php");
        }

        include __DIR__ . "/../views/Recipe/edit_recipe.php";
    }

    public function deleteRecipe($id_recipe) {
        $this->recipeModel->deleteRecipe($id_recipe);
        header("Location: list_recipes.php");
    }
}
?>