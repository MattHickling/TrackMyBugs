<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require '../config/config.php';
require '../vendor/autoload.php';

use Src\Classes\Attachment;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: dashboard.php");
    exit;
}

$bugId = (int)($_POST['bug_id'] ?? 0);

if ($bugId <= 0 || empty($_FILES['attachment']['name'])) {
    die('Invalid attachment upload');
}

$uploadDir = __DIR__ . '/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$originalName = basename($_FILES['attachment']['name']);
$safeName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $originalName);
$targetPath = $uploadDir . $safeName;

if (!move_uploaded_file($_FILES['attachment']['tmp_name'], $targetPath)) {
    die('File upload failed');
}

$relativePath = 'uploads/' . $safeName;

$attachmentRepo = new Attachment($conn);
$attachmentRepo->addAttachment($bugId, $relativePath);

header('Location: bug.php?id=' . $bugId);
exit;
