<?php

class User
{
    private \mysqli $conn;

    public function __construct(\mysqli $conn)
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
        var_dump("Deleting user with ID: " . $id);
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
                COALESCE(c.email_notifications, 0) AS email_notifications,
                COALESCE(c.sms_notifications, 0) AS sms_notifications,
                COALESCE(c.push_notifications, 0) AS push_notifications,
                COALESCE(c.in_app_notifications, 0) AS in_app_notifications
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
        $in_app = isset($data['in_app_notifications']) ? 1 : 0;

        $stmt = $this->conn->prepare(
            "SELECT id FROM user_notification_channels WHERE user_id = ?"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $stmt = $this->conn->prepare(
                "UPDATE user_notification_channels
                SET email_notifications = ?, sms_notifications = ?, push_notifications = ?, in_app_notifications = ?
                WHERE user_id = ?"
            );
            $stmt->bind_param("iiiii", $email, $sms, $push, $in_app, $userId);
            return $stmt->execute();
        } else {
            $stmt = $this->conn->prepare(
                "INSERT INTO user_notification_channels
                (user_id, email_notifications, sms_notifications, push_notifications, created_at)
                VALUES (?, ?, ?, ?, ?, NOW())"
            );
            $stmt->bind_param("iiii", $userId, $email, $sms, $push, $in_app);
            return $stmt->execute();
        }
    }

    public function getAllNotifications(int $userId): array
    {
        $sql = "SELECT
                    id,
                    message,
                    created_at
                FROM notifications
                WHERE user_id = ? AND read_at IS NULL
                ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    

}
