<?php
$recipes = $recipes ?? [];
$flash   = $flash   ?? null;
?>

<?php if ($flash): ?>
    <p style="color: <?= $flash['type'] === 'success' ? 'green' : 'red' ?>;">
        <?= htmlspecialchars($flash['message']) ?>
    </p>
<?php endif; ?>

<h2>Mes Recettes</h2>
<a href="<?= BASE_URL ?>?url=recipe/create">+ Ajouter une recette</a>
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
            <a href="<?= BASE_URL ?>?url=recipe/edit/<?= intval($recipe['id_recipe']) ?>">
                Modifier
            </a>
            &nbsp;|&nbsp;
            <form method="POST"
                  action="<?= BASE_URL ?>?url=recipe/delete/<?= intval($recipe['id_recipe']) ?>"
                  onsubmit="return confirm('Supprimer cette recette ?')"
                  style="display:inline; margin:0;">
                <input type="hidden" name="csrf" value="<?= Security::csrf() ?>">
                <button type="submit"
                        style="background:none; border:none; color:blue; cursor:pointer; padding:0;">
                    Supprimer
                </button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php else: ?>
    <p>Aucune recette trouvée.
        <a href="<?= BASE_URL ?>?url=recipe/create">Ajoutez-en une !</a>
    </p>
<?php endif; ?>