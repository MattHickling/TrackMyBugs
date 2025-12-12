<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include '../templates/header.php';
require '../config/config.php';
require '../vendor/autoload.php';
require '../src/Classes/Bug.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $bug = new Bug($conn);
    $bug_id = $_GET['id'];
    $bug_details = $bug->getBug($bug_id);
}


include '../templates/bug-template.php';