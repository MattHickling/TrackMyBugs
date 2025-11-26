<?php
session_start();
require '../config/config.php';
require '../src/Application/routes.php';


$action = $_GET['action'] ?? null;

if ($action === 'register') {
    require '../src/Application/Service/RegisterUser.php';
    exit;
}

if ($action === 'login') {
    require '../src/Application/Service/LoginUser.php';
    exit;
}
if ($action === 'forgotten') {
    require '../src/Application/Service/ForgottenPassword.php';
    exit;
}