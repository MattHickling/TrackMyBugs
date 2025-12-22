<?php
session_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/Classes/Notification.php';
require_once __DIR__ . '/../src/Classes/InAppNotification.php';
use Src\Classes\InAppNotification;

$notification = new InAppNotification($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    if ($id) {
        $notification->markAsRead((int)$id);
    }
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/profile.php'));
}
