<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/public/assets/css/bootstrap.min.css">
</head>
<body class="p-4 d-flex flex-column align-items-center justify-content-center" style="min-height:100vh;">
<?php if ($success ?? false): ?>
    <div class="alert alert-success text-center" style="max-width:400px;">
        <h4>Password Reset Successfully</h4>
        <p>Your password has been updated. You can now <a href="<?= APP_BASE_URL ?>/public/login.php">login</a>.</p>
    </div>
<?php else: ?>
    <div style="width:400px;">
        <h3 class="mb-4 text-center">Reset your password</h3>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label>New Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-success w-100">Reset Password</button>
        </form>
    </div>
<?php endif; ?>
</body>
</html>
