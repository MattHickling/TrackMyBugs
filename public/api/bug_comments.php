<?php

use Src\Classes\Comment;
require_once '../../config/config.php';
require_once '../../src/Classes/Comment.php';

header('Content-Type: application/json');

$bug_id = isset($_GET['bug_id']) ? (int)$_GET['bug_id'] : 0;

$commentRepo = new Comment($conn);
$comments = $commentRepo->getCommentsByBug($bug_id);

echo json_encode(['data' => $comments]);

