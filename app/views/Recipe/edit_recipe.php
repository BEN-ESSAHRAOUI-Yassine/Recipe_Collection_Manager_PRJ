<?php
$recipe     = $recipe     ?? [];
$categories = $categories ?? [];
?>

<?php if (!empty($_SESSION['flash'])): ?>
    <p style="color: green;"><?= htmlspecialchars($_SESSION['flash']) ?></p>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<h2>Modifier la recette</h2>

<form class="form-card" method="POST" action="<?= BASE_URL ?>?url=recipe/update/<?= intval($recipe['id']) ?>">
    <input type="hidden" name="csrf" value="<?= Security::csrf() ?>">
    <div class="form-group">
    <label>Titre :</label><br>
    <input type="text" name="title"
           value="<?= htmlspecialchars($recipe['title'] ?? '') ?>" required><br><br>
    
    <label>Ingrédients :</label><br>
    <textarea name="ingredients" required><?= htmlspecialchars($recipe['ingredients'] ?? '') ?></textarea><br><br>
    
    <label>Instructions :</label><br>
    <textarea name="instructions" required><?= htmlspecialchars($recipe['instructions'] ?? '') ?></textarea><br><br>
    
    <label>Temps de préparation (min) :</label><br>
    <input type="number" name="prep_time"
           value="<?= intval($recipe['prep_time'] ?? 0) ?>" required><br><br>
    
    <label>Portions :</label><br>
    <input type="text" name="portions"
           value="<?= htmlspecialchars($recipe['portions'] ?? '') ?>" required><br><br>
    
    <label>Catégorie :</label><br>
    <select name="id_category" required>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= intval($cat['id']) ?>"
                <?= (intval($cat['id']) === intval($recipe['id_category'] ?? 0)) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>
    <button class="action-btn btn-submit" type="submit">Mettre à jour</button>
    <a class="action-btn btn-back" href="<?= BASE_URL ?>?url=recipe/index">Annuler</a>
    </div>
</form>