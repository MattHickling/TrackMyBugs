<?php

namespace Src\Classes;

class Notification
{
    private array $channels;

    public function __construct(array $channels)
    {
        $this->channels = $channels;
    }

    public function sendNotification(string $message, array $recipients): bool
    {
        $success = true;

        foreach ($this->channels as $channel) {
            foreach ($recipients as $recipient) {
                if (!$channel->send($recipient, "Notification", $message)) {
                    $success = false;
                }
            }
        }

        return $success;
    }
}
