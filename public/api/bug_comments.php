<?php
require_once '../../config/config.php';
require_once '../../src/Classes/Comment.php';

header('Content-Type: application/json');

$comment = new Comment($conn);
$comments = $comment->getComments();

echo json_encode(['data' => $comments]);
