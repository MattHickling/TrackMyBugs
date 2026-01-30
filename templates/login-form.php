<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = $_SESSION['login_error'] ?? null;
unset($_SESSION['login_error']);

$toastClass = '#dc3545';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= APP_BASE_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= APP_BASE_URL ?>/assets/css/login.css" rel="stylesheet">
    <title>Login</title>
</head>
<body class="bg-light">

<div class="container p-5 d-flex flex-column align-items-center">

<?php if ($message): ?>
    <div class="toast show text-white mb-3" style="background-color: <?= $toastClass ?>;">
        <div class="toast-body"><?= htmlspecialchars($message) ?></div>
    </div>
<?php endif; ?>

<form method="post" action="login.php" class="form-control p-4"
      style="width:380px; box-shadow: rgba(60,64,67,0.3) 0px 1px 2px 0px,
             rgba(60,64,67,0.15) 0px 2px 6px 2px;">

    <div class="text-center mb-3">
        <h5 style="font-weight:700;">Login</h5>
    </div>

    <div class="mb-2">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success w-100 mt-3">Login</button>

    <p class="text-center mt-3" style="font-weight:600;">
        <a href="?action=register">Create Account</a> |
        <a href="?action=forgotten">Forgot Password</a>
    </p>
</form>

</div>

<script src="<?= APP_BASE_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
