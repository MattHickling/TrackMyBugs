<?php
session_start();
require '../config/config.php';
require '../vendor/autoload.php';
require '../src/classes/RegisterUser.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $register = new RegisterUser($conn); 
    $success = $register->register($_POST['first_name'], $_POST['surname'], $_POST['password'], $_POST['email']);

    if ($success) {
        $_SESSION['message'] = "User registered successfully!";
        $_SESSION['first_name'] = $_POST['first_name'];
        header('Location: index.php?page=login');
        exit;
    } else {
        $message = "email already exists.";
    }
}
require '../templates/register-form.php';
