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
        int $userId
    ): void {
        $stmt = $this->conn->prepare(
            "INSERT INTO bugs (project_id, title, description, priority, bug_url, user_id)
             VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "issisi",
            $projectId,
            $title,
            $description,
            $priority,
            $bugUrl,
            $userId
        );

        $stmt->execute();
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
                    u.first_name,
                    p.name AS project_name
                FROM bugs b
                JOIN projects p ON p.id = b.project_id
                LEFT JOIN users u ON u.id = b.user_id
                ORDER BY b.id DESC";

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
                u.first_name,
                p.name AS project_name
             FROM bugs b
             JOIN projects p ON p.id = b.project_id
             LEFT JOIN users u ON u.id = b.user_id
             WHERE b.id = ?"
        );

        $stmt->bind_param("i", $bugId);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc() ?: null;
    }
}
