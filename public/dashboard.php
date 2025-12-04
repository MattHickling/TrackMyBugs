<?php
session_start();
echo 'here';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<h1>Dashboard</h1>
<p>Welcome <?php echo $_SESSION['email']; ?></p>
