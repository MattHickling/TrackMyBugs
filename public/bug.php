<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require '../config/config.php';
require '../vendor/autoload.php';
require '../src/Classes/Bug.php';

$bugRepo = new Bug($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projectId = $_POST['project_id'] ?? null;
    $priority  = $_POST['priority'] ?? null;
    $title     = $_POST['bug_title'] ?? null;
    $description = $_POST['bug_description'] ?? null;
    $bugUrl    = $_POST['bug_url'] ?? null;

    if (!$projectId || !$priority || !$title || !$description) {
        die("Project, priority, title, and description must be provided.");
    }

    $bugRepo->create(
        (int)$projectId,
        $title,
        $description,
        (int)$priority,
        $bugUrl,
        $_SESSION['user_id']
    );

    header('Location: dashboard.php');
    exit;

}

$bug_details = null;
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $bug_id = (int)$_GET['id'];
    $bug_details = $bugRepo->getBug($bug_id);
}

include '../templates/header.php';
include '../templates/bug-template.php';
