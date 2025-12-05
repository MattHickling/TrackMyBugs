<?php
session_start();
echo 'here';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" 
          content="width=device-width, 
                   initial-scale=1.0">
    <link href="../public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/font-awesome.css">
    <link rel="stylesheet" href="../public/assets/css/login.css">
    <title>Reset Password</title>
</head>
<body>
<h1>Dashboard</h1>
<p>Welcome <?php echo $_SESSION['email']; ?></p>
</body>
<!-- <from action=" -->
<script src="../public/assets/js/jquery-3.6.0.min.js"></script>
<script src="../public/assets/js/bootstrap.bundle.min.js"></script>