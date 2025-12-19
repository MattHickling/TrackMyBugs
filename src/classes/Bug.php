<?php

namespace Src\Classes;

use Src\Services\NotificationService;

class Bug
{
    private \mysqli $conn;

    public function __construct(\mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function create(int $projectId, string $title, string $description, string $priority, ?string $bugUrl, int $userId, int $assignedTo): void 
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO bugs (project_id, title, description, priority, bug_url, user_id, assigned_to)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "issisii",
            $projectId,
            $title,
            $description,
            $priority,
            $bugUrl,
            $userId,
            $assignedTo
        );

        $stmt->execute();
        
        $stmt = $this->conn->prepare(
        "SELECT u.*, c.email_notifications, c.sms_notifications, c.push_notifications, c.in_app_notifications
            FROM users u
            LEFT JOIN user_notification_channels c ON c.user_id = u.id
            WHERE u.id = ?"
        );
        
        $stmt->bind_param("i", $assignedTo);
        $stmt->execute();
        $userProfile = $stmt->get_result()->fetch_assoc();

        $stmt = $this->conn->prepare(
        "SELECT p.name
            FROM projects p
            WHERE p.id = ?"
        );
        $stmt->bind_param("i", $projectId);
        $stmt->execute();
        $project = $stmt->get_result()->fetch_assoc();
// dd( $userProfile );
        if ($userProfile) {
            $notification = NotificationService::forUser($userProfile, $this->conn);
            $notification->sendNotification(
                "A new bug '{$title}' has been assigned to you in project '{$project['name']}'.",
                [$userProfile['id']] 
            );

        }


    }

    public function getAllBugs(): array
    {
        $sql = "SELECT
                    b.id,
                    b.title,
                    b.description,
                    b.priority AS priority_name,
                    b.status AS status_name,
                    b.bug_url,
                    b.created_at,
                    reporter.first_name AS reported_by,
                    assignee.first_name AS assigned_to,
                    p.name AS project_name
                FROM bugs b
                JOIN projects p ON p.id = b.project_id

                LEFT JOIN users reporter ON reporter.id = b.user_id
                LEFT JOIN users assignee ON assignee.id = b.assigned_to

                ORDER BY b.id DESC
            ";

        return $this->conn
            ->query($sql)
            ->fetch_all(MYSQLI_ASSOC);
    }


    public function getBug(int $bugId): ?array
    {
        $stmt = $this->conn->prepare(
            "SELECT
                b.id,
                b.title,
                b.description,
                b.priority AS priority_name,
                b.status AS status_name,
                b.bug_url,
                b.created_at,

                reporter.first_name AS reported_by,
                assignee.first_name AS assigned_to,

                p.name AS project_name
            FROM bugs b
            JOIN projects p ON p.id = b.project_id

            LEFT JOIN users reporter ON reporter.id = b.user_id
            LEFT JOIN users assignee ON assignee.id = b.assigned_to

            WHERE b.id = ?
            "
        );

        $stmt->bind_param("i", $bugId);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc() ?: null;
    }

}
