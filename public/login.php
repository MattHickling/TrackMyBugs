<?php
session_start();
require_once '../config/config.php';
require_once '../src/Classes/Login.php';
require_once '../src/Classes/EmailNotification.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $login = new Login($conn);
    $user  = $login->authenticate($email, $password);

    if ($user) {
    
        $pin = random_int(100000, 999999);
        $expires = date('Y-m-d H:i:s', time() + 300);

        $stmt = $conn->prepare(
            "UPDATE users SET mfa_email_pin = ?, mfa_pin_expires = ? WHERE id = ?"
        );
        $stmt->bind_param("ssi", $pin, $expires, $user['id']);
        $stmt->execute();
        $mailer = new \Src\Classes\EmailNotification();
        $subject = "Your login PIN";
        $body = "<p>Your 6-digit login PIN is: <strong>$pin</strong></p><p>It expires in 5 minutes.</p>";

        if (!$mailer->send($user['email'], $subject, $body)) {
            $error = "Failed to send PIN email. Please try again later.";
        } else {
            $_SESSION['pending_user_id'] = $user['id'];
            header('Location: verify_email_mfa.php');
            exit;
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<h2>Login</h2>
<form method="post">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>

    <button type="submit">Login</button>
</form>

<?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
