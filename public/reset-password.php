<?php
require '../config/config.php';
require '../vendor/autoload.php';

if (!isset($_GET['token'])) {
    die('Invalid reset link');
}

$token = $_GET['token'];

$stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Reset link is invalid or has expired");
}

$row = $result->fetch_assoc();
$email = $row['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $hashed = password_hash($password, PASSWORD_BCRYPT);

    $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $update->bind_param("ss", $hashed, $email);
    $update->execute();

    $delete = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
    $delete->bind_param("s", $email);
    $delete->execute();

    echo "Password reset successfully";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="../public/assets/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h3>Reset your password</h3>
    <form method="post">
        <label>New Password</label>
        <input type="password" name="password" class="form-control" required>
        <button class="btn btn-success mt-3">Reset Password</button>
    </form>
</body>
</html>
