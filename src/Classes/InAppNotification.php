<?php

namespace Src\Classes;

use Src\Interfaces\NotificationInterface;

class InAppNotification implements NotificationInterface
{
    private \mysqli $conn;

    public function __construct(\mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function send(string $recipient, string $subject, string $body): bool
    {
        $userId = (int)$recipient; 
        $stmt = $this->conn->prepare(
            "INSERT INTO notifications (user_id, message) VALUES (?, ?)"
        );

        $message = $subject . ': ' . $body;
        $stmt->bind_param("is", $userId, $message);

        return $stmt->execute();
    }

    public function markAsRead(int $notificationId): bool
    {
        $stmt = $this->conn->prepare(
            "UPDATE notifications SET read_at = NOW() WHERE id = ?"
        );
        $stmt->bind_param("i", $notificationId);
        return $stmt->execute();
    }


}
