<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION['pending_user_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';
$toastClass = '#dc3545';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pin = $_POST['pin'] ?? '';
    $userId = $_SESSION['pending_user_id'];

    $stmt = $conn->prepare("SELECT mfa_email_pin, mfa_pin_expires FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result && $result['mfa_email_pin'] === $pin && strtotime($result['mfa_pin_expires']) > time()) {
        $_SESSION['user_id'] = $userId;
        unset($_SESSION['pending_user_id']);

        $stmt = $conn->prepare("UPDATE users SET mfa_email_pin = NULL, mfa_pin_expires = NULL WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        header('Location: dashboard.php');
        exit;
    } else {
        $message = "Invalid or expired PIN.";
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

    <?php if (!empty($message)): ?>
        <div class="toast align-items-center text-white border-0"
             role="alert" aria-live="assertive" aria-atomic="true"
             style="background-color: <?= $toastClass ?>;">
            <div class="d-flex">
                <div class="toast-body"><?= $message ?></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <form method="post" class="form-control mt-5 p-4"
          style="width:380px; box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px,
                 rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;">

        <div class="text-center mb-3">
            <h5 class="p-2" style="font-weight: 700;">Email Verification</h5>
            <p>Enter the 6-digit PIN sent to your email.</p>
        </div>

        <div class="mb-3">
            <label for="pin">PIN</label>
            <input type="text" name="pin" id="pin" class="form-control"
                   required pattern="\d{6}" maxlength="6" placeholder="123456">
        </div>

        <button type="submit" class="btn btn-success w-100 mt-3">Verify PIN</button>

        <p class="text-center mt-3">
            <a href="login.php">Back to Login</a>
        </p>
    </form>
</div>

<script src="<?= APP_BASE_URL ?>/assets/js/jquery-3.6.0.min.js"></script>
<script src="<?= APP_BASE_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
<script>
let toastElList = [].slice.call(document.querySelectorAll('.toast'))
let toastList = toastElList.map(function(toastEl) {
    return new bootstrap.Toast(toastEl, { delay: 3000 });
});
toastList.forEach(toast => toast.show());
</script>

</body>
</html>
