<?php
session_start();

require '../config/config.php';
require '../vendor/autoload.php';
require '../src/Classes/Project.php';

use Src\Classes\Project;

$project = new Project($conn);
$project_details = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? null;
    $description = $_POST['description'] ?? null;
    $language = $_POST['language'] ?? null;

    $success = $project->createProject($name, $description, $language);

    if ($success) {
        $_SESSION['message'] = "Project created successfully!";
        header('Location: dashboard.php'); 
        exit;
    } else {
        $message = "Project already exists.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['project_id'])) {
    $project_id = (int)$_GET['project_id'];
    $project_details = $project->getProject($project_id); 

    if ($project_details) {
        $languageMap = array_column($languages, 'name', 'id');
        $project_details['language_name'] = $languageMap[$project_details['language']] ?? 'Unknown';
    }

}

include '../templates/header.php';
include '../templates/project-template.php';
