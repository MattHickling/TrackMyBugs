<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include '../templates/header.php';
require '../config/config.php';
require '../vendor/autoload.php';
require '../src/Classes/Dashboard.php';
include '../templates/dashboard-template.php';
