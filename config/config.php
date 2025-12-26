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

if (!defined('APP_BASE_URL')) {
    define('APP_BASE_URL', rtrim($_ENV['APP_BASE_URL'], '/'));
}

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

$languages = [
    ['id' => 1, 'name' => 'PHP'],
    ['id' => 2, 'name' => 'JavaScript'],
    ['id' => 3, 'name' => 'Python'],
    ['id' => 4, 'name' => 'Java'],
    ['id' => 5, 'name' => 'C#'],
    ['id' => 6, 'name' => 'Ruby'],
    ['id' => 7, 'name' => 'C++'],
    ['id' => 8, 'name' => 'Go'],
    ['id' => 9, 'name' => 'Swift'],
    ['id' => 10, 'name' => 'Kotlin']
];

// Source - https://stackoverflow.com/a/41671135
// Posted by Coloured Panda, modified by community. See post 'Timeline' for change history
// Retrieved 2025-12-19, License - CC BY-SA 4.0

if (!function_exists('dd')) {
    function dd()
    {
        foreach (func_get_args() as $x) {
            dump($x);
        }
        die;
    }
 }

if (!function_exists('dump')) {
    function dump($var)
    {
        echo '<pre style="background: #f4f4f4; border: 1px solid #ddd; padding: 10px; margin: 10px 0; font-size: 14px; line-height: 1.4; color: #333;">';
        if (is_bool($var)) {
            var_dump($var);
        } elseif (is_null($var)) {
            var_dump($var);
        } else {
            print_r($var);
        }
        echo '</pre>';
    }
 }