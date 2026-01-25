<?php
require __DIR__ . '/../config/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $mfa_code = $_POST['mfa_code'] ?? null;

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password_hash'])) {
        if ($user['mfa_enabled'] && $user['mfa_secret']) {
            if ($mfa_code) {
                $totp = \OTPHP\TOTP::create($user['mfa_secret']);
                if ($totp->verify($mfa_code)) {
                    $_SESSION['user_id'] = $user['id'];
                    header('Location: dashboard.php');
                    exit;
                } else {
                    $message = "Invalid MFA code.";
                    $toastClass = "#dc3545";
                }
            } else {
                $_SESSION['pending_user_id'] = $user['id'];
                $show_mfa = true;
            }
        } else {
            $_SESSION['user_id'] = $user['id'];
            header('Location: dashboard.php');
            exit;
        }
    } else {
        $message = "Invalid email or password.";
        $toastClass = "#dc3545";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= APP_BASE_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= APP_BASE_URL ?>/assets/css/font-awesome.css" rel="stylesheet">
    <link href="<?= APP_BASE_URL ?>/assets/css/login.css" rel="stylesheet">
    <title>Login</title>
</head>
<body class="bg-light">
<div class="container p-5 d-flex flex-column align-items-center">

    <?php if (!empty($message)): ?>
        <div class="toast align-items-center text-white border-0"
             role="alert" aria-live="assertive" aria-atomic="true"
             style="background-color: <?= $toastClass ?? '#000' ?>;">
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
            <h5 class="p-2" style="font-weight: 700;">Login</h5>
        </div>

        <?php if (!empty($show_mfa) && $show_mfa): ?>
            <div class="mb-2">
                <label for="mfa_code">MFA Code</label>
                <input type="text" name="mfa_code" id="mfa_code" class="form-control" required>
            </div>
        <?php else: ?>
            <div class="mb-2">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-2">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-success w-100 mt-3">Login</button>

        <p class="text-center mt-3" style="font-weight: 600;">
            <a href="?action=register">Create Account</a> | 
            <a href="?action=forgotten">Forgot Password</a>
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
