<?php
session_start();

require '../config/config.php';

$page = $_GET['page'] ?? 'login';

if (!isset($_SESSION['user_id']) && $page !== 'login' && $page !== 'register' && $page !== 'forgotten') {
    header('Location: /index.php?page=login');
    exit;
}

switch ($page) {
    case 'login':
        require '../templates/login-form.php';
        break;

    case 'register':
        require '../templates/register-form.php';
        break;

    case 'forgotten':
        require '../templates/forgotten-form.php';
        break;

    case 'dashboard':
        require '../templates/dashboard.php';
        break;

    default:
        echo 'Page not found';
}
