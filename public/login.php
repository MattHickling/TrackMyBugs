<?php
require_once '../config/config.php';
require_once '../src/Classes/Login.php';

$login = new Login($conn);
$message = '';
$toastClass = 'bg-danger';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = $login->authenticate($email, $password);

    if ($user) {
        session_regenerate_id(true);

        // If MFA enabled, redirect to MFA verification
        if (!empty($user['mfa_secret']) && (int)$user['mfa_enabled'] === 1) {
            $_SESSION['mfa_user_id'] = $user['id'];
            header('Location: verify_mfa.php');
            exit;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['email'] = $user['email'];
        header('Location: dashboard.php');
        exit;
    } else {
        $message = 'Invalid email or password';
    }
}
