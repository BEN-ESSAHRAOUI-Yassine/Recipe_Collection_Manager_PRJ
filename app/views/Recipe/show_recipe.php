<?php $recipe = $recipe ?? []; ?>

<style>
    .recipe-detail { max-width: 700px; margin: 30px auto; font-family: sans-serif; }
    .recipe-detail h2 { font-size: 1.8rem; margin-bottom: 5px; }
    .meta { color: #777; font-size: 0.9rem; margin-bottom: 25px; }
    .section { margin-bottom: 25px; }
    .section h3 { border-bottom: 2px solid #e0e0e0; padding-bottom: 6px; margin-bottom: 10px; }
    .actions a, .actions button {
        display: inline-block; margin-right: 10px; padding: 8px 16px;
        border-radius: 5px; text-decoration: none; font-size: 0.9rem; cursor: pointer; border: none;
    }
    .btn-back   { background: #eee; color: #333; }
    .btn-edit   { background: #4CAF50; color: white; }
    .btn-delete { background: #f44336; color: white; }
</style>

<div class="recipe-detail">
    <h2><?= htmlspecialchars($recipe['title'] ?? '') ?></h2>

    <div class="meta">
        <?= intval($recipe['prep_time'] ?? 0) ?> min
        &nbsp;|&nbsp;
        <?= htmlspecialchars($recipe['portions'] ?? '') ?> portions
        &nbsp;|&nbsp;
         <?= htmlspecialchars(substr($recipe['created_at'] ?? '', 0, 10)) ?>
    </div>

    <div class="section">
        <h3>ingrédients</h3>
        <p><?= nl2br(htmlspecialchars($recipe['ingredients'] ?? '')) ?></p>
    </div>

    <div class="section">
        <h3>Instructions</h3>
        <p><?= nl2br(htmlspecialchars($recipe['instructions'] ?? '')) ?></p>
    </div>

    <div class="actions">
        <a class="btn-back" href="<?= BASE_URL ?>?url=recipe/index">Retour</a>
        <a class="btn-edit" href="<?= BASE_URL ?>?url=recipe/edit/<?= intval($recipe['id']) ?>"> Modifier</a>
        <form method="POST"
              action="<?= BASE_URL ?>?url=recipe/delete/<?= intval($recipe['id']) ?>"
              onsubmit="return confirm('Supprimer cette recette ?')"
              style="display:inline;">
            <input type="hidden" name="csrf" value="<?= Security::csrf() ?>">
            <button type="submit" class="btn-delete"> Supprimer</button>
        </form>
        <a href="<?= BASE_URL ?>?url=favorite/add/<?= intval($recipe['id_recipe']) ?>">
            Favorite
        </a>

        <form method="POST" action="<?= BASE_URL ?>?url=note/save/<?= intval($recipe['id_recipe']) ?>">
            <input type="text" name="note" placeholder="Your note">
            <input type="number" name="rating" min="1" max="5">
            <button type="submit">Save</button>
        </form>

    </div>
</div>