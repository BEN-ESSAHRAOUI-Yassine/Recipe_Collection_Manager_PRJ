<?php $recipes = $recipes ?? []; ?>

<h2>Mes Recettes</h2>
<a href="/Recipe_Collection_Manager_PRJ/public/add_recipe.php">+ Ajouter une recette</a>
<br><br>

<?php if (!empty($recipes)): ?>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Titre</th>
        <th>Catégorie</th>
        <th>Temps (min)</th>
        <th>Portions</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($recipes as $recipe): ?>
    <tr>
        <td><?= htmlspecialchars($recipe['title']) ?></td>
        <td><?= htmlspecialchars($recipe['category_name'] ?? '') ?></td>
        <td><?= intval($recipe['prep_time']) ?></td>
        <td><?= htmlspecialchars($recipe['portions']) ?></td>
        <td>
            <a href="/Recipe_Collection_Manager_PRJ/public/edit_recipe.php?id=<?= intval($recipe['id_recipe']) ?>">
                Modifier
            </a>
            &nbsp;|&nbsp;
            <a href="/Recipe_Collection_Manager_PRJ/public/delete_recipe.php?id=<?= intval($recipe['id_recipe']) ?>"
               onclick="return confirm('Supprimer cette recette ?')">
                Supprimer
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
    <p>Aucune recette trouvée. <a href="/Recipe_Collection_Manager_PRJ/public/add_recipe.php">Ajoutez-en une !</a></p>
<?php endif; ?>