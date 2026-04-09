<?php

class NoteController extends BaseController {

    private $model;

    public function __construct() {
        Security::requireLogin();
        $this->model = new Note();
    }

    public function index() {
        $userId = $_SESSION['user']['id'];
        $notes = $this->model->getByUser($userId);

        $this->render('note/list', compact('notes'));
    }

    public function save($recipeId) {
        $note   = Security::sanitize($_POST['note']);
        $rating = (int)$_POST['rating'];

        $this->model->addOrUpdate(
            $_SESSION['user']['id'],
            $recipeId,
            $note,
            $rating
        );

        header("Location: " . BASE_URL . "?url=recipe/index");
    }
}