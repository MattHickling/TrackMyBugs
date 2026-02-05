<?php

use Src\Classes\User;

session_start();
require_once '../config/config.php';
require_once '../src/Classes/User.php';

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
// dd( $profile );
if(isset($profile['id'])) {
    $user_notifications = $user->getAllNotifications($profile['id']);
    // dd( $notifications );
}

require_once '../templates/profile-template.php';
