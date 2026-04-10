<?php
$categories = $categories ?? [];
$flash      = $flash      ?? null;
?>

<?php if ($flash): ?>
    <p style="color: <?= $flash['type'] === 'success' ? 'green' : 'red' ?>;">
        <?= htmlspecialchars($flash['message']) ?>
    </p>
<?php endif; ?>

<h2>Ajouter une recette</h2>
<form method="POST" action="<?= BASE_URL ?>?url=recipe/store">
    <input type="hidden" name="csrf" value="<?= Security::csrf() ?>">

    <label>Titre :</label><br>
    <input type="text" name="title" required><br><br>

    <label>Ingrédients :</label><br>
    <textarea name="ingredients" required></textarea><br><br>

    <label>Instructions :</label><br>
    <textarea name="instructions" required></textarea><br><br>

    <label>Temps de préparation (min) :</label><br>
    <input type="number" name="prep_time" required><br><br>

    <label>Portions :</label><br>
    <input type="text" name="portions" required><br><br>

    <label>Catégorie :</label><br>
    <select name="id_category" required>
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= intval($cat['id']) ?>">
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        <?php else: ?>
            <option value="">Aucune catégorie disponible</option>
        <?php endif; ?>
    </select><br><br>

    <button type="submit">Ajouter la recette</button>
    <a class="action-btn btn-back" href="<?= BASE_URL ?>?url=recipe/index">Annuler</a>
</form>