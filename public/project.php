<?php
session_start();
require '../config/config.php';
require '../vendor/autoload.php';
require '../src/Classes/Project.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project = new Project($conn); 
    $success = $project->createProject(
        $_POST['name'], 
        $_POST['description'], 
        $_POST['language'] 
    );

    if ($success) {
        $_SESSION['message'] = "Project created successfully!";
        header('Location: dashboard.php'); 
        exit;
    } else {
        $message = "Project already exists.";
    }
}
