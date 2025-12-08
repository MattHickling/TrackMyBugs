<?php
session_start();
include '../config/config.php';
include '../src/classes/Login.php';

$login = new Login($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($login->authenticate($email, $password)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Invalid password";
        $toastClass = "bg-danger";
    }
}
