<?php
require __DIR__ . '/../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['pending_user_id'])) {
    header('Location: login-form.php');
    exit;
}

$message = null;
$toastClass = '#dc3545';
$userId = $_SESSION['pending_user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pin = $_POST['pin'] ?? '';

    $stmt = $conn->prepare(
        "SELECT mfa_email_pin, mfa_pin_expires FROM users WHERE id = ?"
    );
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (
        !$user ||
        $user['mfa_email_pin'] !== $pin ||
        strtotime($user['mfa_pin_expires']) < time()
    ) {
        $message = 'Invalid or expired PIN.';
    } else {
        $clear = $conn->prepare(
            "UPDATE users SET mfa_email_pin = NULL, mfa_pin_expires = NULL WHERE id = ?"
        );
        $clear->bind_param("i", $userId);
        $clear->execute();

        unset($_SESSION['pending_user_id']);
        session_regenerate_id(true);
        $_SESSION['user_id'] = $userId;

        header('Location: dashboard.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= APP_BASE_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= APP_BASE_URL ?>/assets/css/login.css" rel="stylesheet">
    <title>Verify PIN</title>
</head>
<body class="bg-light">

<div class="container p-5 d-flex flex-column align-items-center">

<?php if ($message): ?>
    <div class="toast show text-white mb-3" style="background-color: <?= $toastClass ?>;">
        <div class="toast-body"><?= htmlspecialchars($message) ?></div>
    </div>
<?php endif; ?>

<form method="post" class="form-control p-4"
      style="width:380px; box-shadow: rgba(60,64,67,0.3) 0px 1px 2px 0px,
             rgba(60,64,67,0.15) 0px 2px 6px 2px;">

    <div class="text-center mb-3">
        <h5 style="font-weight:700;">Email Verification</h5>
        <p>Enter the 6-digit PIN sent to your email.</p>
    </div>

    <div class="mb-3">
        <label>PIN</label>
        <input type="text" name="pin" class="form-control"
               required pattern="\d{6}" maxlength="6" placeholder="123456">
    </div>

    <button type="submit" class="btn btn-success w-100">Verify PIN</button>

    <p class="text-center mt-3">
        <a href="login-form.php">Back to Login</a>
    </p>
</form>

</div>

<script src="<?= APP_BASE_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
