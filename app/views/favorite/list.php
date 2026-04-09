<h2>Mes Favoris </h2>

<?php foreach ($favorites as $r): ?>
<div class="card">
    <strong><?= htmlspecialchars($r['title']) ?></strong>

    <div class="card-actions">
        <a href="<?= BASE_URL ?>?url=favorite/remove/<?= $r['id'] ?>" class="btn-delete">
            Remove
        </a>
    </div>
</div>
<?php endforeach; ?>