<?php
require_once '../config/config.php';
require_once '../src/Classes/InAppNotification.php';
session_start();

if (!isset($_POST['id'], $_SESSION['user_id'])) exit;

$notificationId = (int)$_POST['id'];
$userId = $_SESSION['user_id'];

$notif = new \Src\Classes\InAppNotification($conn);

$stmt = $conn->prepare("SELECT user_id FROM notifications WHERE id = ?");
$stmt->bind_param("i", $notificationId);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if ($row && $row['user_id'] === $userId) {
    $notif->markAsRead($notificationId);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
