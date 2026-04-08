<?php

class CategoryController {
    private $CategoryM;

    public function __construct() {
        $this->CategoryM = new Category();
    }

    public function MesCategory() {
        $message = ""; 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars($_POST['name']);
            $result = $this->CategoryM->addCategory($name);

            if ($result === "exists") {
                $message = "Cette catégorie existe déjà !";
            } else {
                $message = "Catégorie ajoutée avec succès !";
            }
        }


 $viewFile = __DIR__ . "/../views/Category/add_category.php";
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo "Erreur : fichier de vue introuvable !";
        }
    }
     public function listCategories() {
        $message = "";
        $editCategory = null;

        $categories = $this->CategoryM->getCategories();
         

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['update'])) {
                $id   = intval($_POST['id']);
                $name = htmlspecialchars(trim($_POST['name']));

                $result = $this->CategoryM->updateCategory($id, $name);

                if ($result === "exists") {
                    $message = "Cette catégorie existe déjà !";
                } else {
                    $message = "Catégorie mise à jour avec succès !";
                }

                $categories = $this->CategoryM->getCategories();

            } elseif (isset($_POST['edit'])) {
                $id = intval($_POST['edit']);

                foreach ($categories as $cat) {
                    if ((int)$cat['id'] === $id) {
                        $editCategory = $cat;
                        break;
                    }
                }
            }
        }
        
        include __DIR__ . "/../views/Category/list_category.php";
    }

}