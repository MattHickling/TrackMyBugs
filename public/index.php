<?php
session_start();
require '../config/config.php';
require '../src/Application/routes.php';


$action = $_GET['action'] ?? null;

if ($action === 'register') {
    require '../src/classes/RegisterUser.php';
    exit;
}

if ($action === 'login') {
    require '../src/classes/LoginUser.php';
    exit;
}
if ($action === 'forgotten') {
    require '../src/classes/ForgottenPassword.php';
    exit;
}