<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require '../config/config.php';
require '../vendor/autoload.php';
require '../src/classes/Dashboard.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dashboard = new Dashboard($conn);
    // var_dump($_POST['priority']);

    $dashboard->addBug($_POST['bug_title'], $_POST['bug_description'], $_POST['priority'], $_SESSION['user_id']);
}

include '../templates/dashboard-template.php';
