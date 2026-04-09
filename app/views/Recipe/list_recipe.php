<?php
$recipes = $recipes ?? [];
$flash   = $flash   ?? null;
?>

<?php if (!empty($_SESSION['flash'])): ?>
    <p style="color: green;"><?= htmlspecialchars($_SESSION['flash']) ?></p>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<h2>Mes Recettes</h2>
<a href="<?= BASE_URL ?>?url=recipe/create">Ajouter une recette</a>
<br><br>

<?php if (!empty($recipes)): ?>

    <div class="search-filter-bar">

        <div class="search-wrap">
            <input
                type="text"
                id="searchInput"
                class="search-input"
                placeholder="Rechercher une recette…"
            >
        </div>

        <div class="filter-wrap">
            <select id="categoryFilter" class="filter-select">
                <option value="">Toutes les catégories</option>
                <?php
                    $uniqueCats = [];
                    foreach ($recipes as $r) {
                        $cat = $r['category_name'] ?? '';
                        if ($cat && !in_array($cat, $uniqueCats)) {
                            $uniqueCats[] = $cat;
                        }
                    }
                    sort($uniqueCats);
                    foreach ($uniqueCats as $cat):
                ?>
                    <option value="<?= htmlspecialchars($cat) ?>">
                        <?= htmlspecialchars($cat) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="reset-wrap">
            <button type="button" id="resetBtn" class="reset-btn">Reinitialiser</button>
        </div>

    </div>

    <div class="results-count">
        <span id="countVisible"><?= count($recipes) ?></span> recette affichee
    </div>

    <table border="1" cellpadding="5" cellspacing="0" id="recipeTable">
        <tr>
            <th>Titre</th>
            <th>Catégorie</th>
            <th>Temps (min)</th>
            <th>Portions</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($recipes as $recipe): ?>
        <tr
            data-title="<?= strtolower(htmlspecialchars($recipe['title'])) ?>"
            data-category="<?= htmlspecialchars($recipe['category_name'] ?? '') ?>"
        >
            <td>
                <a href="<?= BASE_URL ?>?url=recipe/show/<?= intval($recipe['id']) ?>">
                    <?= htmlspecialchars($recipe['title']) ?>
                </a>
            </td>
            <td><?= htmlspecialchars($recipe['category_name'] ?? '') ?></td>
            <td><?= intval($recipe['prep_time']) ?></td>
            <td><?= htmlspecialchars($recipe['portions']) ?></td>
            <td>
                <a href="<?= BASE_URL ?>?url=recipe/edit/<?= intval($recipe['id']) ?>">
                    Modifier
                </a>
                &nbsp;|&nbsp;
                <form method="POST"
                      action="<?= BASE_URL ?>?url=recipe/delete/<?= intval($recipe['id']) ?>"
                      onsubmit="return confirm('Supprimer cette recette ?')"
                      style="display:inline; margin:0;">
                    <input type="hidden" name="csrf" value="<?= Security::csrf() ?>">
                    <button type="submit"
                            style="background:none; border:none; color:blue; cursor:pointer; padding:0;">
                        Supprimer
                    </button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="no-results" id="noResults" style="display:none;">
        Aucune recette ne correspond à votre recherche.
    </div>

<?php else: ?>
    <p>Aucune recette trouvée.
        <a href="<?= BASE_URL ?>?url=recipe/create">Ajoutez-en une !</a>
    </p>
<?php endif; ?>

<script>
    const searchInput    = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const resetBtn       = document.getElementById('resetBtn');
    const rows           = document.querySelectorAll('#recipeTable tr[data-title]');
    const countEl        = document.getElementById('countVisible');
    const noResults      = document.getElementById('noResults');
    const table          = document.getElementById('recipeTable');

    function filterRecipes() {
        const search = searchInput.value.toLowerCase().trim();
        const cat    = categoryFilter.value;
        let visible  = 0;

        rows.forEach(row => {
            const matchSearch = row.dataset.title.includes(search);
            const matchCat    = !cat || row.dataset.category === cat;

            if (matchSearch && matchCat) {
                row.style.display = '';
                visible++;
            } else {
                row.style.display = 'none';
            }
        });

        countEl.textContent = visible;
        table.style.display     = visible === 0 ? 'none' : '';
        noResults.style.display = visible === 0 ? 'block' : 'none';
    }

    searchInput.addEventListener('input', filterRecipes);
    categoryFilter.addEventListener('change', filterRecipes);
    resetBtn.addEventListener('click', function () {
        searchInput.value    = '';
        categoryFilter.value = '';
        filterRecipes();
    });
</script>