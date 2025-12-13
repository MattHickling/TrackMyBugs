<?php
session_start();
require '../config/config.php';
require '../src/Classes/Comment.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentRepo = new Comment($conn);
    $commentRepo->createComment(
        (int)$_POST['bug_id'],
        (int)$_SESSION['user_id'],
        $_POST['comment']
    );

    header('Location: bug.php?id=' . $_POST['bug_id']);
    exit;
}
