<?php
require_once __DIR__ . '/../config/config.php';
require '../src/Classes/User.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user->updateNotificationPreferences($_SESSION['user_id'], $_POST);
    header('Location: profile.php');
    exit;
}

$profile = $user->getById($_SESSION['user_id']);

require_once __DIR__ . '/../templates/profile-template.php';
