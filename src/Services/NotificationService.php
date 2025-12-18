<?php

namespace Src\Services;
use Src\Classes\Notification;
use Src\Classes\EmailNotification;
use Src\Classes\PushNotification;

class NotificationService
{
    public static function forUser(array $userProfile): Notification
    {
        $channels = [];

        if ($userProfile['email_notifications']) {
            $channels[] = new EmailNotification();
        }

        // if ($userProfile['sms_notifications']) {
        //     $channels[] = new SmsNotification();
        // }
        file_put_contents(__DIR__ . '/../../logs/debug.log', "push_notifications flag: " . ($userProfile['push_notifications'] ?? 'not set') . "\n", FILE_APPEND);

        if ($userProfile['push_notifications']) {
            $channels[] = new PushNotification();
        }

        return new Notification($channels);
    }
}
