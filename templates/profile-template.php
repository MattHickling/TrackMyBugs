<?php require_once 'header.php'; 
use Carbon\Carbon;
?>
<?php
use OTPHP\TOTP;

if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
        $totp = TOTP::create();
        $totp->setLabel($profile['email']);
        $secret = $totp->getSecret();

        $stmt = $conn->prepare("UPDATE users SET mfa_secret = ?, mfa_enabled = 1 WHERE id = ?");
        $stmt->bind_param("si", $secret, $profile['id']);
        $stmt->execute();

        $mfa_enabled = 1;
        $profile['mfa_secret'] = $secret;
        $qr_url = $totp->getProvisioningUri();
    }

?>

<div class="container-fluid py-3">

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">User Profile</h5>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> <?= htmlspecialchars($profile['first_name'] . ' ' . $profile['surname']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($profile['email']) ?></p>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Security</h5>
        </div>
        <div class="card-body">
            <p>Email multi-factor authentication is enabled for all accounts.</p>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Notification Preferences</h5>
        </div>
        <div class="card-body">
            <form method="post" action="post_save_notification_prefs.php">

                <div class="form-check mb-2">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="email_notifications"
                        name="email_notifications"
                        value="1"
                        <?= (int)($profile['email_notifications'] ?? 0) === 1 ? 'checked' : '' ?>
                    >
                    <label class="form-check-label" for="email_notifications">
                        Email notifications
                    </label>
                </div>

                <div class="form-check mb-2">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="sms_notifications"
                        name="sms_notifications"
                        value="1"
                        <?= (int)($profile['sms_notifications'] ?? 0) === 1 ? 'checked' : '' ?>
                    >
                    <label class="form-check-label" for="sms_notifications">
                        SMS notifications
                    </label>
                </div>

                <div class="form-check mb-2">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="push_notifications"
                        name="push_notifications"
                        value="1"
                        <?= (int)($profile['push_notifications'] ?? 0) === 1 ? 'checked' : '' ?>
                    >
                    <label class="form-check-label" for="push_notifications">
                        Push notifications
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="in_app_notifications"
                        name="in_app_notifications"
                        value="1"
                        <?= (int)($profile['in_app_notifications'] ?? 0) === 1 ? 'checked' : '' ?>
                    >
                    <label class="form-check-label" for="in_app_notifications">
                        In-app notifications
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">
                    Save Preferences
                </button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Notifications</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Message</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($user_notifications)): ?>
                        <?php foreach ($user_notifications as $n):
                            $date = Carbon::parse($n['created_at'])->format('H:i:s d/m/Y');
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($date) ?></td>
                                <td><?= htmlspecialchars($n['message']) ?></td>
                                <td class="text-end">
                                    <form method="post" action="post_mark_as_read.php">
                                        <input type="hidden" name="id" value="<?= (int)$n['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                No notifications found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card shadow-sm border-danger">
        <div class="card-header bg-light">
            <h5 class="mb-0 text-danger">Danger Zone</h5>
        </div>
        <div class="card-body">
            <form
                method="post"
                action="post_delete_account.php"
                onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');"
            >
                <input type="hidden" name="user_id" value="<?= (int)$profile['id'] ?>">
                <button type="submit" class="btn btn-danger">
                    Delete Account
                </button>
            </form>
        </div>
    </div>

</div>

<?php require_once 'footer.php'; ?>
