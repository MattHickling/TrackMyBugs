<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require '../config/config.php';
require '../vendor/autoload.php';
require '../src/classes/Dashboard.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $register = new Dashboard($conn); 
    $success = $register->register($_POST['username'], $_POST['password'], $_POST['email']);

    if ($success) {
        $_SESSION['message'] = "User registered successfully!";
        header('Location: index.php?page=login');
        exit;
    } else {
        $message = "Username or email already exists.";
    }
}

include '../templates/header.php';

