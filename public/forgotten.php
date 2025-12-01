<?php
session_start();
require '../config/config.php';
require '../vendor/autoload.php';
require '../src/classes/ForgottenLogin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $forgotten = new ForgottenLogin($conn); 
    $success = $forgotten->forgotten($_POST['email']);

    if ($success) {
        $_SESSION['message'] = "User registered successfully!";
        header('Location: index.php?page=login');
        exit;
    } else {
        $message = "Username or email already exists.";
    }
}
require '../templates/register-form.php';
