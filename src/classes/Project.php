<?php

class Project
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function createProject()
    {
        $stmt = $this->conn->prepare("INSERT INTO projects (name, description, created_at, language) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $_POST['name'], $_POST['description'], $_POST['created_at'], $_POST['language']);

        return $stmt->execute();
    }
    
    public function getAllProjects(): array
    {
        $sql = "SELECT
                    p.id,
                    p.name,
                    p.description,
                    p.language,
                    p.created_at
                FROM projects p
                ORDER BY p.id DESC";

        return $this->conn
            ->query($sql)
            ->fetch_all(MYSQLI_ASSOC);
    }
}
