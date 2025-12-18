<?php

namespace Src\Interfaces;

interface NotificationInterface
{
    public function send(string $recipient, string $subject, string $body): bool;
}