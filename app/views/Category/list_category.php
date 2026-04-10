<?php $message = $message ?? ''; $editCategory = $editCategory ?? null; $categories = $categories ?? []; ?>

<?php if (!empty($message)): ?>
    <p style="color:<?= str_contains($message,'succès') ? 'green' : 'red' ?>">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<?php if (!empty($editCategory)): ?>
    <h3>Modifier categorie</h3>
    <form class="form-card" method="POST" action="<?= BASE_URL ?>?url=category/update/<?= intval($editCategory['id']) ?>">
        <input type="text" name="name" value="<?= htmlspecialchars($editCategory['name']) ?>" required>
        <button class="action-btn btn-success" type="submit">Mettre à jour</button>
        <a class="action-btn btn-back" href="<?= BASE_URL ?>?url=category/index">Annuler</a>
    </form>
<?php endif; ?>

<h3>Liste des catégories</h3>
<a class="action-btn btn-submit" href="<?= BASE_URL ?>?url=category/create">Ajouter une category</a>
<br><br>
<table class="table-wrap">
    <tr><th>ID</th><th>Nom</th><th>Actions</th></tr>
    <?php foreach ($categories as $cat): ?>
    <tr>
        <td><?= intval($cat['id']) ?></td>
        <td><?= htmlspecialchars($cat['name']) ?></td>
        <td>
            <a class="action-btn btn-edit" href="<?= BASE_URL ?>?url=category/edit/<?= intval($cat['id']) ?>">Modifier</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>