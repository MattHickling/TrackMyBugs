<?php

use PHPUnit\Framework\TestCase;
use Src\Interfaces\NotificationInterface;
use Src\Classes\EmailNotification;

class NotificationInterfaceTest extends TestCase
{
    public function testEmailNotificationImplementsInterface()
    {
        $notification = new EmailNotification();

        $this->assertInstanceOf(
            NotificationInterface::class,
            $notification
        );
    }
}
