<?php

require_once '../../config/config.php';
require_once '../../src/Classes/Bug.php';

header('Content-Type: application/json');

$bugRepo = new Bug($conn);
$bugs = $bugRepo->getAllBugs();

echo json_encode([
    'data' => $bugs
]);
