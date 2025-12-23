<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['data' => []]);
    exit;
}

require '../../config/config.php';
require '../../vendor/autoload.php';

use Src\Classes\Bug;

$bugRepo = new Bug($conn);

$project_id = isset($_GET['project_id']) ? (int)$_GET['project_id'] : null;

if ($project_id) {
    $bugs = $bugRepo->getBugsByProject($project_id);
} else {
    $bugs = [];
}

echo json_encode(['data' => $bugs]);
