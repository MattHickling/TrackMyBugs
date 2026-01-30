<?php
require __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/Classes/EmailNotification.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = null;
$toastClass = '#dc3545';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, email, password_hash FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        $message = 'Invalid email or password.';
    } else {
        $pin = random_int(100000, 999999);
        $expires = date('Y-m-d H:i:s', time() + 300);

        $update = $conn->prepare(
            "UPDATE users SET mfa_email_pin = ?, mfa_pin_expires = ? WHERE id = ?"
        );
        $update->bind_param("ssi", $pin, $expires, $user['id']);
        $update->execute();

        $mailer = new \Src\Classes\EmailNotification();
        $subject = 'Your login PIN';
        $body = "<p>Your 6-digit login PIN is <strong>$pin</strong>.</p><p>It expires in 5 minutes.</p>";

        if (!$mailer->send($user['email'], $subject, $body)) {
            $message = 'Failed to send PIN email.';
        } else {
            $_SESSION['pending_user_id'] = $user['id'];
            header('Location: verify_email_mfa.php');
            exit;
        }
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
    <title>Login</title>
</head>
<body class="bg-light">

<div class="container p-5 d-flex flex-column align-items-center">

<?php if ($message): ?>
    <div class="toast show text-white mb-3" style="background-color: <?= $toastClass ?>;">
        <div class="toast-body"><?= htmlspecialchars($message) ?></div>
    </div>
<?php endif; ?>

<form method="post" action="" class="form-control p-4"
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
