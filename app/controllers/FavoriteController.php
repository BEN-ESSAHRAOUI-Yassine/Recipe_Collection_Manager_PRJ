<?php

class FavoriteController extends BaseController {

    private $model;

    public function __construct() {
        Security::requireLogin();
        $this->model = new Favorite();
    }

    public function index() {
        $userId = $_SESSION['user']['id'];
        $favorites = $this->model->getByUser($userId);

        $this->render('favorite/list', compact('favorites'));
    }

    public function add($recipeId) {
        $this->model->add($_SESSION['user']['id'], $recipeId);
        header("Location: " . BASE_URL . "?url=recipe/index");
    }

    public function remove($recipeId) {
        $this->model->remove($_SESSION['user']['id'], $recipeId);
        header("Location: " . BASE_URL . "?url=favorite/index");
    }
}