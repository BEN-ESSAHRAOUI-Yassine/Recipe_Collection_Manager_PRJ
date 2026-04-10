<?php $message = $_SESSION['flash'] ?? ''; unset($_SESSION['flash']); ?>
<?php if (!empty($message)): ?>
    <p style="color:<?= str_contains($message,'succès') ? 'green' : 'red' ?>">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>
<form method="POST" action="<?= BASE_URL ?>?url=category/store">
    <label for="name">Nom de la catégorie</label>
    <input id="name" type="text" name="name" placeholder="Nom catégorie" required>
    <button type="submit">Ajouter</button>
    <a href="<?= BASE_URL ?>?url=category/index">Reteur</a>
<br><br>
</form>