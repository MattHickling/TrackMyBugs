<?php require_once 'header.php'; 
use Carbon\Carbon;
?>

<div class="container-fluid py-3">

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">User Profile</h5>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1">
                        <strong>Name:</strong>
                        <?= htmlspecialchars($profile['first_name'] . ' ' . $profile['surname']) ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1">
                        <strong>Email:</strong>
                        <?= htmlspecialchars($profile['email']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Notification Preferences</h5>
        </div>

        <div class="card-body">
            <form method="post">
                <div class="form-check mb-2">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="email_notifications"
                        name="email_notifications"
                        <?= (int)$profile['email_notifications'] === 1 ? 'checked' : '' ?>
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
                        <?= (int)$profile['sms_notifications'] === 1 ? 'checked' : '' ?>
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
                        <?= (int)$profile['push_notifications'] === 1 ? 'checked' : '' ?>
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
                        <?= (int)$profile['in_app_notifications'] === 1 ? 'checked' : '' ?>
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

        <div class="card-body">
            <div class="table-responsive">
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
                            <?php foreach ($user_notifications as $user_notification):
                                $created_at = Carbon::parse($user_notification['created_at'])->format('H:i:s d/m/Y');
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($created_at) ?></td>
                                    <td><?= htmlspecialchars($user_notification['message'] ?? '') ?></td>
                                    <td class="text-end">
                                        <form action="post_mark_as_read.php" method="post">
                                            <input type="hidden" name="id" value="<?= (int)$user_notification['id'] ?>">
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
    </div>

    <div class="card shadow-sm border-danger">
        <div class="card-header bg-light">
            <h5 class="mb-0 text-danger">Danger Zone</h5>
        </div>

        <div class="card-body">
            <form
                action="post_delete_account.php"
                method="post"
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
