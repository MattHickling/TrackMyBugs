<?php
require_once '../config/config.php';
require_once '../src/Classes/InAppNotification.php';
session_start();
// if (!isset($_POST['id'], $_SESSION['user_id'])) exit;
// dd($_REQUEST);
// dd('456');
$bugId = (int)$_REQUEST['bug_id'];
$userId = $_SESSION['user_id'];

$bug = new \Src\Classes\Bug($conn);

$stmt = $conn->prepare("SELECT id FROM bugs WHERE id = ?");
$stmt->bind_param("i", $bugId);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

// dd('123');
$bug->markAsClosed($bugId);
echo json_encode(['success' => true]);
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/profile.php'));
