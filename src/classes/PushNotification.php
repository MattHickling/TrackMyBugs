<?php
namespace Src\Classes;

use Src\Interfaces\NotificationInterface;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include __DIR__.'/vendor/autoload.php';

use Joli\JoliNotif\Notification;
use Joli\JoliNotif\DefaultNotifier;

class PushNotification implements NotificationInterface
{
    // private PHPMailer $mailer;

    public function __construct()
    {
        // $this->conn = $conn;
    }

    public function send(string $recipient, string $subject, string $body): bool
    {
        file_put_contents(__DIR__ . '/../../logs/debug.log', "send() method called\n", FILE_APPEND);
        try {
            $notification = (new Notification())
                ->setTitle($subject)
                ->setBody($body)
                ->setIcon(__DIR__.'/../../public/assets/images/alert.png') 
                ->addOption('subtitle', 'This is a subtitle')
                ->addOption('sound', 'Frog');

            $notifier = new DefaultNotifier();

            $result = $notifier->send($notification);
            file_put_contents(__DIR__ . '/../../logs/debug.log', "Push notification sent? " . ($result ? 'yes' : 'no') . "\n", FILE_APPEND);
      
            return true;
        } catch (Exception $e) {
            file_put_contents(__DIR__ . '/../../logs/debug.log', "Push notification failed: ".$e->getMessage()."\n", FILE_APPEND);
            return false;
        }
    }
}
