<?php
$message     = $message     ?? "";
$editCategory = $editCategory ?? null;
$categories  = $categories  ?? [];
?>

<?php if (!empty($message)): ?>
    <p style="color: <?= ($message === "Cette catégorie existe déjà !") ? "red" : "green"; ?>;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<?php if (!empty($editCategory)): ?>
    <h3>Modifier catégorie</h3>
    <form method="POST" action="http://localhost/Recipe_Collection_Manager_PRJ/public/list_category.php">
        <input type="hidden" name="id" value="<?= intval($editCategory['id']) ?>">
        <label for="name">Nom de la catégorie</label>
        <input id="name" type="text" name="name"
               value="<?= htmlspecialchars(trim($editCategory['name'])) ?>" required>
        <button type="submit" name="update">Mettre à jour</button>
        <button type="submit" name="cancel">Annuler</button>
    </form>
    <hr>
<?php endif; ?>

<h3>Liste des catégoriesh</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Actions</th>
    </tr>
    <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $cat): ?>
            <tr>
                <td><?= intval($cat['id']) ?></td>
                <td><?= htmlspecialchars(trim($cat['name'])) ?></td>
                <td>
                    <form method="POST" 
                          action="http://localhost/Recipe_Collection_Manager_PRJ/public/list_category.php" 
                          style="display:inline;">
                        <button type="submit" name="edit" value="<?= intval($cat['id']) ?>">
                            Modifier
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">Aucune catégorie trouvée</td>
        </tr>
    <?php endif; ?>
</table>