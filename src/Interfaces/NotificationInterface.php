<?php

namespace Src\Interfaces;

interface NotificationInterface
{
    public function send(string $message, array $recipients): bool;
}