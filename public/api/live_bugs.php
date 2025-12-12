<?php
require_once '../../config/config.php';
require_once '../../src/Classes/Dashboard.php';

header('Content-Type: application/json');

$dashboard = new Dashboard($conn);
$bugs = $dashboard->getAllBugs();

echo json_encode(['data' => $bugs]);
exit;
