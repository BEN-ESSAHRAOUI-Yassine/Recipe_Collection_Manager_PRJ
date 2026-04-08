<?php
$message    = $message    ?? "";
$categories = $categories ?? [];
$recipe     = $recipe     ?? [];
?>

<h2>Modifier la recette</h2>

<?php if (!empty($message)): ?>
    <p style="color:red;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Titre :</label><br>
    <input type="text" name="title" value="<?= htmlspecialchars($recipe['title'] ?? '') ?>" required><br><br>

    <label>Ingrédients :</label><br>
    <textarea name="ingredients" required><?= htmlspecialchars($recipe['ingredients'] ?? '') ?></textarea><br><br>

    <label>Instructions :</label><br>
    <textarea name="instructions" required><?= htmlspecialchars($recipe['instructions'] ?? '') ?></textarea><br><br>

    <label>Temps de préparation (min) :</label><br>
    <input type="number" name="prep_time" value="<?= intval($recipe['prep_time'] ?? 0) ?>" required><br><br>

    <label>Portions :</label><br>
    <input type="text" name="portions" value="<?= htmlspecialchars($recipe['portions'] ?? '') ?>" required><br><br>

    <label>Catégorie :</label><br>
    <select name="id_category" required>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= intval($cat['id']) ?>"
                <?= (intval($cat['id']) === intval($recipe['id_category'] ?? 0)) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Mettre à jour</button>
</form>