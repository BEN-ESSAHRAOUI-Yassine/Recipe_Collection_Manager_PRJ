<?php $message = $_SESSION['flash'] ?? ''; unset($_SESSION['flash']); ?>
<?php if (!empty($message)): ?>
    <p style="color:<?= str_contains($message,'succès') ? 'green' : 'red' ?>">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>
<form class="form-card" method="POST" action="<?= BASE_URL ?>?url=category/store">
    <label for="name">Nom de la catégorie</label>
    <input id="name" type="text" name="name" placeholder="Nom catégorie" required>
    <br><br>
    <button class="action-btn btn-success" type="submit">Ajouter</button>
    <a class="action-btn btn-back" href="<?= BASE_URL ?>?url=category/index">Retour</a>

</form>