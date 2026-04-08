<h2><?= isset($user) ? 'Edit User' : 'Create User' ?></h2>

<div class="form-card">
<form method="POST" action="<?= BASE_URL ?>?url=admin/<?= isset($user) ? 'update-user' : 'store-user' ?>">
    <input type="hidden" name="csrf"    value="<?= Security::csrf() ?>">
    <input type="hidden" name="id" value="<?= (int)($user['id'] ?? 0) ?>">

    <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name"
               value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email"
               value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
    </div>

    <?php if (!isset($user)): ?>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Min 6 characters" required minlength="6">
    </div>
    <?php endif; ?>

    <div class="form-group">
        <label for="role">Role</label>

        <?php if ((int)($user['id'] ?? 0) === $_SESSION['user']['id']): ?>
            <!-- Prevent admin from changing his own role -->
            <input type="hidden" name="role" value="admin">
            <input type="text" value="Admin" disabled>
        <?php else: ?>
            <select id="role" name="role">
                <?php foreach (['admin', 'chef'] as $r): ?>
                <option value="<?= $r ?>" <?= (($user['role'] ?? '') === $r) ? 'selected' : '' ?>>
                    <?= ucfirst($r) ?>
                </option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>
    </div>

    <div class="flex-gap" style="margin-top:16px;">
        <button type="submit" class="btn-submit">Save User</button>
        <a href="<?= BASE_URL ?>?url=admin/users" class="action-btn btn-back">Cancel</a>
    </div>
</form>
</div>
