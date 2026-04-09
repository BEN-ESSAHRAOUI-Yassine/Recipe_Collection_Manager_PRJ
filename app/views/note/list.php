<h2>Mes Notes </h2>

<?php foreach ($notes as $n): ?>
<div class="card">
    <strong><?= htmlspecialchars($n['title']) ?></strong>
    <p>Rating: <?= intval($n['rating']) ?>/5</p>
    <p><?= htmlspecialchars($n['note']) ?></p>
</div>
<?php endforeach; ?>