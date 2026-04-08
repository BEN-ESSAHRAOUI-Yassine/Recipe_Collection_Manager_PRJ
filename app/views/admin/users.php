<div class="top-bar">
    <h2 style="margin:0;">Users</h2>
    <div class="flex-gap">
        <!-- Search form -->
        <form method="GET" action="" class="search-form">
            <input type="hidden" name="url" value="admin/users">
            <input type="text" name="search" placeholder="Search name or email..."
                   value="<?= htmlspecialchars($search ?? '') ?>">
            <button type="submit">Search</button>
        </form>
        <a href="<?= BASE_URL ?>?url=admin/create-user" class="action-btn btn-submit">+ Add User</a>
    </div>
</div>

<div class="table-wrap">
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($users)): ?>
        <tr><td colspan="4" style="text-align:center; color:#94A3B8;">No users found.</td></tr>
    <?php else: ?>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u['username']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars($u['role']) ?></td>
            <td>
                <div class="table-actions">

                    <!-- Edit -->
                    <a href="<?= BASE_URL ?>?url=admin/edit-user&id=<?= (int)$u['id'] ?>"
                       class="action-btn btn-edit">Edit</a>

                    <?php if ((int)$u['id'] !== $_SESSION['user']['id']): ?>
                        <form method="POST" action="<?= BASE_URL ?>?url=admin/delete-user"
                            onsubmit="return confirm('Delete <?= htmlspecialchars($u['username']) ?>?')">

                            <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                            <input type="hidden" name="csrf" value="<?= Security::csrf() ?>">

                            <button type="submit" class="action-btn btn-delete">
                                Delete
                            </button>
                        </form>
                        <?php endif; ?>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
</div>