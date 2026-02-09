<?php
session_start();

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../vendor/autoload.php';

use Src\Classes\ForgottenLogin;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// dd($_POST);
    $forgotten = new ForgottenLogin($conn);
    $forgotten->forgotten($_POST['email']);

    $_SESSION['message'] = 'If the email exists, a reset link has been sent.';
    $_SESSION['toast_class'] = 'bg-success';

    header('Location: forgotten.php');
    exit;
}

require __DIR__ . '/../templates/login-form.php';
