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

// Fetch all bugs
$bugs = $bugRepo->getAllBugs();

// Return in DataTables format
echo json_encode(['data' => $bugs]);
