<?php

namespace Src\Interfaces;

interface NotificationInterface
{
    public function sendNotification(string $message, array $recipients): bool;
}