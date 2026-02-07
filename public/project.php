<?php
session_start();

require '../config/config.php';
require '../vendor/autoload.php';
require '../src/Classes/Project.php';
require '../src/Classes/Bug.php';

use Src\Classes\Project;
use Src\Classes\Bug;

$project = new Project($conn);
$project_details = null;
$projects = []; 
$bugRepo = new Bug($conn);

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

    $bug_details = $bugRepo->getBugsByProject($project_id);

} else {

    if (!isset($project_id)) {
        if (!empty($_GET['q'])) {
            $projects = $project->searchProjects(
                (int)$_SESSION['user_id'],
                trim($_GET['q'])
            );
        } else {
            $projects = $project->getAllProjects((int)$_SESSION['user_id']);
        }

        foreach ($projects as &$p) {
            $p['language_name'] = $p['language_name'] ?? 'Unknown';
            $p['bug_count']     = $p['bug_count'] ?? 0;
            $p['created_at']    = $p['created_at'] ?? 'Unknown';
        }
    }

}

include '../templates/header.php';
include '../templates/project-template.php';
