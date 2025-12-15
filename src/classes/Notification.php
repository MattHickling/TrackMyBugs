<?php

namespace Src\Classes;

use Src\Interfaces\NotificationInterface;

class Notification implements NotificationInterface
{
    public function sendNotification(string $message, array $recipients): bool
    {
        foreach ($recipients as $recipient) {
            echo "Sending notification to {$recipient}: {$message}\n";
        }
        return true;
    }
    
    public function getUserNotificationChannels(int $userId): array
    {
        return ['email', 'sms'];
    }
}