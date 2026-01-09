<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require '../config/config.php';
require '../vendor/autoload.php';

use Src\Classes\Bug;

$bugRepo = new Bug($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bugId       = (int)$_POST['bug_id'];
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $priority    = (int)$_POST['priority'];
    $assignedTo  = (int)$_POST['assigned_to'];

    $bugUrl = trim($_POST['bug_url'] ?? '');
    // dd($bugUrl);
    $bugUrl = $bugUrl === '' ? null : $bugUrl;

    $assignedTo = $_POST['assigned_to'] ?? null;
    $assignedTo = $assignedTo == "0" ? null : (int)$assignedTo;

    $bugRepo->updateBug(
        $bugId,
        $title,
        $description,
        $priority,
        $bugUrl,
        $assignedTo
    );

    header('Location: bug.php?id=' . $bugId);
    exit;
}


$bug = null;
if (isset($_GET['id'])) {
    $bug = $bugRepo->getBug((int)$_GET['id']);
}

include '../templates/header.php';
include '../templates/edit-bug-template.php';
include '../templates/footer.php';
