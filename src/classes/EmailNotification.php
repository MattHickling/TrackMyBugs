<?php
namespace Src\Classes;

use Src\Interfaces\NotificationInterface;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailNotification implements NotificationInterface
{
    private PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
    }

    public function send(string $recipient, string $subject, string $body): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->isSMTP();
            $this->mailer->Host       = $_ENV['MAIL_HOST'];
            $this->mailer->SMTPAuth   = true;
            $this->mailer->Username   = $_ENV['MAIL_USERNAME'];
            $this->mailer->Password   = $_ENV['MAIL_PASSWORD'];
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port       = $_ENV['MAIL_PORT'];

            $this->mailer->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
            // $this->mailer->addAddress($recipient);
            $this->mailer->addAddress($_ENV['DEV_EMAIL']);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $body;

            $this->mailer->send();

            return true;
        } catch (Exception $e) {
            error_log("Email to {$recipient} failed: {$this->mailer->ErrorInfo}");
            return false;
        }
    }
}
