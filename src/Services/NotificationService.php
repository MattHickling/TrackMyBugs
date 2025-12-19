<?php

namespace Src\Services;
use Src\Classes\Notification;
use Src\Classes\PushNotification;
use Src\Classes\EmailNotification;
use Src\Classes\InAppNotification;

class NotificationService
{
    public static function forUser(array $userProfile, \mysqli $conn): Notification
    {
        $channels = [];
        if ($userProfile['email_notifications']) {
            $channels[] = new EmailNotification();
        }
        // if ($userProfile['sms_notifications']) {
        //     $channels[] = new SmsNotification();
        // }

        // if ($userProfile['push_notifications']) {
        //     $channels[] = new PushNotification();
        // }

        if ($userProfile['in_app_notifications'] ?? true) {
            $channels[] = new InAppNotification($conn);
        }


        return new Notification($channels);
    }
}
