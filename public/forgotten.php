<?php
session_start();
require '../config/config.php';
require '../vendor/autoload.php';
require '../src/Classes/ForgottenLogin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $forgotten = new ForgottenLogin($conn); 
    $success = $forgotten->forgotten($_POST['email']);

   echo __LINE__;
    if ($success) {
        $_SESSION['message'] = "If the email exists, a reset link has been sent.";
        $_SESSION['toast_class'] = "bg-success";
    } else {
        $_SESSION['message'] = "If the email exists, a reset link has been sent.";
        $_SESSION['toast_class'] = "bg-success";
    }

    header('Location: forgotten.php');
    exit();
}
require '../templates/register-form.php';
