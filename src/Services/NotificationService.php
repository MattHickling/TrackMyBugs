<?php

namespace Src\Services;
use Src\Classes\Notification;
use Src\Classes\EmailNotification;

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

        // if ($userProfile['push_notifications']) {
        //     $channels[] = new PushNotification();
        // }

        return new Notification($channels);
    }
}
