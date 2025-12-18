<?php

namespace Src\Classes;

use Src\Interfaces\NotificationInterface;

class Notification implements NotificationInterface
{
    public function __construct(array $channels)
    {
        $this->channels = $channels;
    }

    public function send(string $message, array $recipients): bool
    {
        $success = true;

        foreach ($this->channels as $channel) {
            if (!$channel->send($message, $recipients)) {
                $success = false;
            }
        }
        return true;
    }
    
    // public function getUserNotificationChannels(int $userId): array
    // {
    //     return ['email', 'sms'];
    // }
}