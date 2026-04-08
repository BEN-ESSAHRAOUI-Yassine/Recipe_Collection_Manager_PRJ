<form method="POST">
    <label>Titre :</label>
    <input type="text" name="title" required>
<br><br>
    <label>Ingrédients :</label>
    <textarea name="ingredients" required></textarea>
<br><br>
    <label>Instructions :</label>
    <textarea name="instructions" required></textarea>
  <br><br>
    <label>Temps de préparation (min) :</label>
    <input type="number" name="prep_time" required>
    <br><br>

    <label>Portions :</label>
    <input type="text" name="portions" required>
<br><br>
    <label>Catégorie :</label>
    <select name="id_category" required>
        <?php if(!empty($categories)): ?>
            <?php foreach($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
            <?php endforeach; ?>
        <?php else: ?>
            <option value="">Aucune catégorie disponible</option>
        <?php endif; ?>
    </select>

    <button type="submit">Ajouter la recette</button>
</form>