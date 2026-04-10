<?php $message = $message ?? ''; $editCategory = $editCategory ?? null; $categories = $categories ?? []; ?>

<?php if (!empty($message)): ?>
    <p style="color:<?= str_contains($message,'succès') ? 'green' : 'red' ?>">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<?php if (!empty($editCategory)): ?>
    <h3>Modifier categorie</h3>
    <form method="POST" action="<?= BASE_URL ?>?url=category/update/<?= intval($editCategory['id']) ?>">
        <input type="text" name="name" value="<?= htmlspecialchars($editCategory['name']) ?>" required>
        <button type="submit">Mettre à jour</button>
        <a href="<?= BASE_URL ?>?url=category/index">Annuler</a>
    </form>
<?php endif; ?>

<h3>Liste des catégories</h3>
<a href="<?= BASE_URL ?>?url=category/create">Ajouter une category</a>
<br><br>
<table border="1" cellpadding="5">
    <tr><th>ID</th><th>Nom</th><th>Actions</th></tr>
    <?php foreach ($categories as $cat): ?>
    <tr>
        <td><?= intval($cat['id']) ?></td>
        <td><?= htmlspecialchars($cat['name']) ?></td>
        <td>
            <a href="<?= BASE_URL ?>?url=category/edit/<?= intval($cat['id']) ?>">Modifier</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>