<?php require_once 'header.php'; ?>

<h2>User Profile</h2>

<p>
    <strong>Name:</strong>
    <?= htmlspecialchars($profile['first_name'] . ' ' . $profile['surname']) ?>
</p>

<p>
    <strong>Email:</strong>
    <?= htmlspecialchars($profile['email']) ?>
</p>

<h3>Notification Preferences</h3>

<form method="post">
    <label>
        <input type="checkbox" name="email_notifications"
            <?= $profile['email_notifications'] ? 'checked' : '' ?>>
        Email notifications
    </label>

    <br>

    <label>
        <input type="checkbox" name="sms_notifications"
            <?= $profile['sms_notifications'] ? 'checked' : '' ?>>
        SMS notifications
    </label>

    <br>

    <label>
        <input type="checkbox" name="push_notifications"
            <?= $profile['push_notifications'] ? 'checked' : '' ?>>
        Push notifications
    </label>

    <br><br>

    <button type="submit">Save preferences</button>
</form>

<form action="post_delete_account.php" method="post" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
    <input type="hidden" name="user_id" value="<?= (int)$profile['id'] ?>">
    <button type="submit" class="btn btn-danger mt-3">Delete Account</button>
</form>

<?php require_once 'footer.php'; ?>
