<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../vendor/autoload.php';

use Src\Classes\Login;
use Src\Classes\EmailNotification;

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $login = new Login($conn);
    $user = $login->authenticate($email, $password);

    if ($user) {
        $pin = random_int(100000, 999999);
        $expires = date('Y-m-d H:i:s', time() + 300);

        $stmt = $conn->prepare(
            "UPDATE users SET mfa_email_pin = ?, mfa_pin_expires = ? WHERE id = ?"
        );
        $stmt->bind_param("ssi", $pin, $expires, $user['id']);
        $stmt->execute();

        $mailer = new EmailNotification();
        $subject = "Your login PIN";
        $body = "<p>Your 6-digit login PIN is: <strong>$pin</strong></p><p>It expires in 5 minutes.</p>";
        $mailer->send($user['email'], $subject, $body);

        $_SESSION['pending_user_id'] = $user['id'];
        header('Location: verify_email_mfa.php');
        exit;
    } else {
        $_SESSION['login_error'] = "Invalid email or password.";
        header('Location: login-form.php');
        exit;
    }
}

require __DIR__ . '/../templates/login-form.php';
