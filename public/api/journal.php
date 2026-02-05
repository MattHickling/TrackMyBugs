<?php
session_start();
require '../../config/config.php';
require '../../vendor/autoload.php';

use Src\Classes\Journal;

header('Content-Type: application/json');

$journalRepo = new Journal($conn);

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false]);
    exit;
}

$journalId = (int)$_GET['id'];
$journal = $journalRepo->getJournalById($journalId);

if (!$journal) {
    echo json_encode(['success' => false]);
    exit;
}

echo json_encode([
    'success' => true,
    'data' => $journal
]);
