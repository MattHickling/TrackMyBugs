<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Carbon\Carbon;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..'); 
$dotenv->load();

$HOSTNAME = $_ENV['DB_HOST'];
$USERNAME = $_ENV['DB_USERNAME'];
$PASSWORD = $_ENV['DB_PASSWORD'];
$DB_NAME = $_ENV['DB_DATABASE'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($HOSTNAME, $USERNAME, $PASSWORD, $DB_NAME);
    $conn->set_charset('utf8mb4'); 
} catch (\mysqli_sql_exception $e) {
    die("Database connection failed: " . $e->getMessage());
}

$priorities = [
    ['id' => 1, 'name' => 'Low'],
    ['id' => 2, 'name' => 'Medium'],
    ['id' => 3, 'name' => 'High'],
    ['id' => 4, 'name' => 'Critical']
];
