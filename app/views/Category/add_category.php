<?php
if (isset($message) && !empty($message)) {
    $color = ($message === "Cette catégorie existe déjà !") ? "red" : "green";
    echo "<p style='color: $color;'>$message</p>";
}
?>

<form method="POST" action="http://localhost/Recipe_Collection_Manager_PRJ/public/add_category.php">
    <label for="name">Nom de la catégorie</label>
    <input id="name" type="text" name="name" placeholder="Nom catégorie" required>
    <button type="submit">Ajouter</button>
</form>