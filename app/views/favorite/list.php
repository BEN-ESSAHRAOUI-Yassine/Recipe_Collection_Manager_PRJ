<h2>Mes Favoris </h2>

<?php foreach ($favorites as $r): ?>
<div class="card">
    <a><strong><?= htmlspecialchars($r['title']) ?></strong></a>

    <div class="card-actions">
        <a class="action-btn btn-delete" href="<?= BASE_URL ?>?url=favorite/remove/<?= $r['id'] ?>" class="btn-delete">
            Remove
        </a>
    </div>
</div>
<?php endforeach; ?>