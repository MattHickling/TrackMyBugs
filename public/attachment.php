<?php
session_start();
require '../config/config.php';
require '../src/Classes/Attachment.php';
use Carbon\Carbon;
use Src\Classes\Attachment;

$attachmentRepo = new Attachment($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attachmentRepo->addAttachment(
        (int)$_POST['bug_id'],
        $_POST['file_path']
    );
    
   
    header('Location: bug.php?id=' . $_POST['bug_id']);
    exit;
}

$attachment_details = null;

include '../templates/header.php';
include '../templates/bug-template.php';
