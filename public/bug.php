<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require '../config/config.php';
require '../vendor/autoload.php';

use Src\Classes\Bug;
use Src\Classes\Comment; 
use Src\Classes\Attachment;
use Src\Services\NotificationService;

$bug_details = null; 
$bugRepo = new Bug($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projectId   = $_POST['project_id'] ?? null;
    $priority    = $_POST['priority'] ?? null;
    $title       = $_POST['bug_title'] ?? null;
    $description = $_POST['bug_description'] ?? null;
    $assigned_to = $_POST['assigned_to'] ?? null;
    $bugUrl      = $_POST['bug_url'] ?? null;

    if (!$projectId || !$priority || !$title || !$description) {
        die("Project, priority, title, and description must be provided.");
    }

    $bugRepo->create(
        (int)$projectId,
        $title,
        $description,
        (int)$priority,
        $bugUrl,
        $_SESSION['user_id'],
        (int)$assigned_to
    );

    $bugId = $conn->insert_id;
    if (!empty($_FILES['attachments']['name'][0])) {

       $bugUploadDir = BUG_UPLOADS_DIR;
        if (!is_dir($bugUploadDir)) mkdir($bugUploadDir, 0755, true);

        $attachmentRepo = new Attachment($conn);
        $allowedTypes = ['image/png', 'image/jpeg', 'application/pdf'];
        $maxSize = 5 * 1024 * 1024;

        foreach ($_FILES['attachments']['name'] as $index => $originalName) {

            if ($_FILES['attachments']['error'][$index] !== UPLOAD_ERR_OK) continue;
            if ($_FILES['attachments']['size'][$index] > $maxSize) continue;

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $_FILES['attachments']['tmp_name'][$index]);
            finfo_close($finfo);
            if (!in_array($mimeType, $allowedTypes)) continue;

            $safeName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', basename($originalName));
            $targetPath = $bugUploadDir . $safeName;
            $relativePath = 'uploads/bug/' . $safeName;

            if (move_uploaded_file($_FILES['attachments']['tmp_name'][$index], $targetPath)) {
                $attachmentRepo->addAttachment($bugId, $relativePath);
            }
        }
    }

    header('Location: dashboard.php');
    exit;
}

$bugs = [];
$bug_details = null;

if (isset($_GET['id'])) {
    $bug_id = (int)$_GET['id'];

    $bug_details = $bugRepo->getBug($bug_id, $_SESSION['user_id']);
    if (!$bug_details) {
        die("Bug not found or you don’t have permission to view it.");
    }
    $commentRepo = new Comment($conn);
    $comments = $commentRepo->getCommentsByBug($bug_id);

} else {
    if (!empty($_GET['q'])) {
        $bugs = $bugRepo->searchBugs(
            (int)$_SESSION['user_id'],
            trim($_GET['q'])
        );
    } else {
        $bugs = $bugRepo->getAllBugs(
            (int)$_SESSION['user_id']
        );
    }
}

include '../templates/header.php';
include '../templates/bug-template.php';
if (isset($_GET['id']) && $bug_details) {
    include '../templates/comment-template.php';
}