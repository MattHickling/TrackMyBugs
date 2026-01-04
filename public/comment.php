<?php
session_start();
require '../config/config.php';
require '../vendor/autoload.php';

use Src\Classes\Comment;
use Src\Classes\Attachment;

$commentRepo = new Comment($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bugId = (int)$_POST['bug_id'];
    $userId = (int)$_SESSION['user_id'];
    $commentText = $_POST['comment'];

    $commentRepo->createComment($bugId, $userId, $commentText);
    $commentId = $conn->insert_id;

    if (!empty($_FILES['attachments']['name'][0])) {

        $commentUploadDir = COMMENT_UPLOADS_DIR;
        if (!is_dir($commentUploadDir)) {
            mkdir($commentUploadDir, 0755, true);
        }

        $attachmentRepo = new Attachment($conn);

        $allowedTypes = ['image/png', 'image/jpeg', 'application/pdf'];
        $maxSize = 5 * 1024 * 1024;

        foreach ($_FILES['attachments']['name'] as $index => $originalName) {

            if ($_FILES['attachments']['error'][$index] !== UPLOAD_ERR_OK) {
                continue;
            }

            if ($_FILES['attachments']['size'][$index] > $maxSize) {
                continue;
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $_FILES['attachments']['tmp_name'][$index]);
            finfo_close($finfo);

            if (!in_array($mimeType, $allowedTypes)) {
                continue;
            }

            $safeName = uniqid() . '_' . preg_replace(
                '/[^a-zA-Z0-9._-]/',
                '',
                basename($originalName)
            );

            $targetPath = $commentUploadDir . $safeName;
            $relativePath = 'uploads/comments/' . $safeName;

            if (move_uploaded_file($_FILES['attachments']['tmp_name'][$index], $targetPath)) {
                $attachmentRepo->addAttachment(null, $relativePath, $commentId);
            }
        }
    }

    header('Location: bug.php?id=' . $bugId);
    exit;
}


$comment_details = null;
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $commentId = (int)$_GET['id'];
    $comment_details = $commentRepo->getCommentById($commentId); 

    $attachmentRepo = new Attachment($conn);
    $attachments = $attachmentRepo->getAttachmentsByComment($commentId);
}

include '../templates/header.php';
include '../templates/comment-template.php';
