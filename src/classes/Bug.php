<?php

class Bug
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function create(
        int $projectId,
        string $title,
        string $description,
        string $priority,
        ?string $bugUrl,
        int $userId,
        int $assignedTo
    ): void {
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
    }

    public function getAllBugs(): array
    {
        $sql = "
            SELECT
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
            "
            SELECT
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
