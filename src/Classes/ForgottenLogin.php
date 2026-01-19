<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ForgottenLogin
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function forgotten($email)
    {
        $stmt = $this->conn->prepare("SELECT id, first_name, surname FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return false;
        }

        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(32));

        $stmt = $this->conn->prepare("UPDATE users SET reset_token = ?, reset_expires = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE id = ?");
        $stmt->bind_param("si", $token, $user['id']);
        $stmt->execute();

        return $this->sendResetEmail($email, $token);
    }

    private function sendResetEmail($email, $token)
    {
        $resetUrl = $_ENV['APP_URL'] . "public/reset-password.php?token=" . urlencode($token);
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['MAIL_USERNAME'];
            $mail->Password   = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $_ENV['MAIL_PORT'];

            $mail->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Password Reset Request";
            $mail->Body = "
                <p>You requested a password reset.</p>
                <p><a href=\"$resetUrl\">Click here to reset your password.</a></p>
                <p>This link expires in 1 hour.</p>
            ";

            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }
}
