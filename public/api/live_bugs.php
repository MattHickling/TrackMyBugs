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

$bugs = $bugRepo->getAllBugs((int)$_SESSION['user_id']);

echo json_encode(['data' => $bugs]);
