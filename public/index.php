<?php
session_start();
require '../config/config.php';
require '../vendor/autoload.php';


$action = $_GET['action'] ?? null;

if ($action === 'register') {
    require '../templates/register-form.php';
    exit;
}elseif ($action === 'forgotten') {
    require '../templates/forgotten-form.php';
    exit;
}else{
     require '../templates/login-form.php';
}