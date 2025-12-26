<?php
session_start();
require '../config/config.php';
require '../src/Classes/Comment.php';
use Carbon\Carbon;
use Src\Classes\Comment;

$commentRepo = new Comment($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentRepo->createComment(
        (int)$_POST['bug_id'],
        (int)$_SESSION['user_id'],
        $_POST['comment']
    );

    header('Location: bug.php?id=' . $_POST['bug_id']);
    exit;
}

$comment_details = null;
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $commentId = (int)$_GET['id'];
    $comment_details = $commentRepo->getCommentById($commentId); 
}

include '../templates/header.php';
include '../templates/comment-template.php';
