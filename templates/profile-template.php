<?php require_once 'header.php'; 
use Carbon\Carbon;
?>
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
            <?= (int)$profile['email_notifications'] === 1 ? 'checked' : '' ?>>
        Email notifications
    </label>
    <br>
    <label>
        <input type="checkbox" name="sms_notifications"
            <?= (int)$profile['sms_notifications'] === 1  ? 'checked' : '' ?>>
        SMS notifications
    </label>
    <br>
    <label>
        <input type="checkbox" name="push_notifications"
            <?= (int)$profile['push_notifications'] === 1 ? 'checked' : '' ?>>
        Push notifications
    </label>
    <br>
    <label>
        <input type="checkbox" name="in_app_notifications"
            <?= (int)$profile['in_app_notifications'] === 1 ? 'checked' : '' ?>>
        In App notifications
    </label>
    <br><br>
    <button type="submit">Save preferences</button>
</form>
<div class="text-right">
<form action="post_delete_account.php" method="post" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
    <input type="hidden" name="user_id" value="<?= (int)$profile['id'] ?>">
    <button type="submit" class="btn btn-danger mt-3">Delete Account</button>
</form>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Message</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($user_notifications)):?>
            <?php foreach ($user_notifications as $user_notification): 
                $created_at = Carbon::parse($user_notification['created_at'])->format('H:i:s d/m/Y');
                // dd($user_notification);
                ?>
                <tr>
                    <td><?= htmlspecialchars($created_at?? '') ?></td>
                    <td><?= htmlspecialchars($user_notification['message'] ?? '') ?></td>
                    <td><form action="post_mark_as_read.php" method="post">
                            <input type="hidden" name="id" value="<?= (int)$user_notification['id'] ?>">
                            <button type="submit" class="btn btn-danger mt-3">Delete Notification</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">No notifications found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>


<?php require_once 'footer.php'; ?>
