<?php
session_start();
require_once '../config/config.php';
require_once '../vendor/autoload.php';
use OTPHP\TOTP;

if (!isset($_SESSION['mfa_user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['mfa_user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$message = '';
$toastClass = '#dc3545';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mfa_code = $_POST['mfa_code'] ?? '';
    if ($user['mfa_secret']) {
        $totp = TOTP::create($user['mfa_secret']);
        if ($totp->verify($mfa_code)) {
            $_SESSION['user_id'] = $user['id'];
            unset($_SESSION['mfa_user_id']);
            header('Location: dashboard.php');
            exit;
        } else {
            $message = 'Invalid MFA code';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MFA Verification</title>
    <link href="<?= APP_BASE_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container p-5 d-flex flex-column align-items-center">
    <?php if ($message): ?>
        <div class="alert alert-danger"><?= $message ?></div>
    <?php endif; ?>
    <form method="post" class="form-control p-4" style="width: 380px;">
        <h5 class="text-center mb-3">Enter MFA Code</h5>
        <input type="text" name="mfa_code" class="form-control mb-3" placeholder="6-digit code" required>
        <button type="submit" class="btn btn-success w-100">Verify</button>
    </form>
</div>
<script src="<?= APP_BASE_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
