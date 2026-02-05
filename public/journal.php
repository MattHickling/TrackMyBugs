<?php
session_start();
require '../config/config.php';
require '../vendor/autoload.php';

use Src\Classes\Journal;

$journalRepo = new Journal($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = (int)$_SESSION['user_id'];
    $entry = trim($_POST['entry']);
    $description = trim($_POST['description']);

    if ($entry !== '') {
        $journalRepo->create($userId, $entry, $description);
    }

    header('Location: journal.php');
    exit;
}

$journal_details = null;
if (isset($_GET['id'])) {
    $journalId = (int)$_GET['id'];
    $journal_details = $journalRepo->getJournalById($journalId);
}

$journals = $journalRepo->getAllJournals();

include '../templates/header.php';
include '../templates/journal-template.php';
