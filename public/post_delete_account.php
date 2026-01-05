<?php
session_start();
include '../config/config.php';
include '../src/Classes/User.php';

$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['user_id'];

    if ($user->deleteUser($id)) {
        session_destroy();
        header("Location: index.php");
        exit;
    } else {
        $message = "Failed to delete account";
        $toastClass = "bg-danger";
    }
}
