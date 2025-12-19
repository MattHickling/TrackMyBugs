<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['data' => []]);
    exit;
}

require '../../config/config.php';
require '../../vendor/autoload.php';

use Src\Classes\Project;

$projectRepo = new Project($conn);

$projects = $projectRepo->getAllProjects();

header('Content-Type: application/json');
echo json_encode(['data' => $projects]);
