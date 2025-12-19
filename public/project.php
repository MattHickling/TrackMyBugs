<?php
session_start();
require '../config/config.php';
require '../vendor/autoload.php';
require '../src/Classes/Project.php'; 
dd('here');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id   = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? null;
        $description = $_POST['description'] ?? null;
        $created = $_POST['created'] ?? null;
        $language = $_POST['language'] ?? null;
        $project = new Project($conn); 
        $success = $project->createProject(
        $_POST['name'], 
        $_POST['description'], 
        $_POST['language'] 
    );
// dd('here');
    if ($success) {
        $_SESSION['message'] = "Project created successfully!";
        header('Location: dashboard.php'); 
        exit;
    } else {
        $message = "Project already exists.";
    }

    $projectRepo->create(
        (int)$id,
        $name,
        $description,
        (int)$created,
        $language
    );
}
