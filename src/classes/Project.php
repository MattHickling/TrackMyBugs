<?php

namespace Src\Classes;

class Project
{
    private \mysqli $conn;

    public function __construct(\mysqli $conn)
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
                    p.created_at,
                    COUNT(b.id) AS bug_count
                FROM projects p
                LEFT JOIN bugs b ON p.id = b.project_id
                GROUP BY p.id, p.name, p.description, p.language, p.created_at
                ORDER BY p.id DESC";

        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }


}
