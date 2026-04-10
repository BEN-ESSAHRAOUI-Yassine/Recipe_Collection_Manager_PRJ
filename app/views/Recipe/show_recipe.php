<?php $recipe = $recipe ?? []; ?>

<div class="form-card">
    <h2><?= htmlspecialchars($recipe['title'] ?? '') ?></h2>

    <div class="card">
        <?= ($time = intval($recipe['prep_time'])) <= 20 ? '⚡⏱️ ' . $time : '⏱️'. $time  ?> min
        &nbsp;|&nbsp;
        <?= htmlspecialchars($recipe['portions'] ?? '') ?> portions
        &nbsp;|&nbsp;
         <?= htmlspecialchars(substr($recipe['created_at'] ?? '', 0, 10)) ?>
    </div>

    <div class="card">
        <h3>ingrédients</h3>
        <p><?= nl2br(htmlspecialchars($recipe['ingredients'] ?? '')) ?></p>
    </div>

    <div class="card">
        <h3>Instructions</h3>
        <p><?= nl2br(htmlspecialchars($recipe['instructions'] ?? '')) ?></p>
    </div>

    <div class="card card-actions">
        <a class="action-btn btn-back" href="<?= BASE_URL ?>?url=recipe/index">Retour</a>
        <a class="action-btn btn-edit" href="<?= BASE_URL ?>?url=recipe/edit/<?= intval($recipe['id']) ?>"> Modifier</a>
        <form method="POST"
              action="<?= BASE_URL ?>?url=recipe/delete/<?= intval($recipe['id']) ?>"
              onsubmit="return confirm('Supprimer cette recette ?')"
              style="display:inline;">
            <input type="hidden" name="csrf" value="<?= Security::csrf() ?>">
            <button type="submit" class="action-btn btn-delete"> Supprimer</button>
        </form>
        <a class="action-btn btn-favorite" href="<?= BASE_URL ?>?url=favorite/add/<?= intval($recipe['id']) ?>"> Favorite</a>

        <form method="POST" action="<?= BASE_URL ?>?url=note/save/<?= intval($recipe['id']) ?>">
            <input type="text" name="note" placeholder="Your note"> 
            <input type="number" name="rating" min="1" max="5">
            <button class="action-btn btn-success" type="submit">Save</button>
        </form>

    </div>
</div>