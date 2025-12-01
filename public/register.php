<?php
session_start();
require '../config/config.php';
require '../vendor/autoload.php';
require '../src/classes/RegisterUser.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $register = new RegisterUser($conn); 
    $success = $register->register($_POST['username'], $_POST['password'], $_POST['email']);

    if ($success) {
        $_SESSION['message'] = "User registered successfully!";
        header('Location: index.php?page=login');
        exit;
    } else {
        $message = "Username or email already exists.";
    }
}
require '../templates/register-form.php';
