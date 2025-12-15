<?php

class User
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function getUserById(int $id): array|null
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM users WHERE id = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function updateUserEmail(int $id, string $newEmail): bool
    {
        $stmt = $this->conn->prepare(
            "UPDATE users SET email = ? WHERE id = ?"
        );
        $stmt->bind_param("si", $newEmail, $id);
        return $stmt->execute();
    }

    public function deleteUser(int $id): bool
    {
        var_dump("Deleting user with ID: " . $id); // Debug line
        $stmt = $this->conn->prepare(
            "DELETE FROM users WHERE id = ?"
        );
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getById(int $id): array|null
    {
        $stmt = $this->conn->prepare(
            "SELECT u.*,
                    c.email_notifications,
                    c.sms_notifications,
                    c.push_notifications
             FROM users u
             LEFT JOIN user_notification_channels c ON c.user_id = u.id
             WHERE u.id = ?"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function updateNotificationPreferences(int $userId, array $data): bool
    {
        $email = isset($data['email_notifications']) ? 1 : 0;
        $sms   = isset($data['sms_notifications']) ? 1 : 0;
        $push  = isset($data['push_notifications']) ? 1 : 0;

        $stmt = $this->conn->prepare(
            "INSERT INTO user_notification_channels
                (user_id, email_notifications, sms_notifications, push_notifications, created_at)
             VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)
             ON DUPLICATE KEY UPDATE
                email_notifications = VALUES(email_notifications),
                sms_notifications = VALUES(sms_notifications),
                push_notifications = VALUES(push_notifications)"
        );

        $stmt->bind_param("iiii", $userId, $email, $sms, $push);
        return $stmt->execute();
    }
}
