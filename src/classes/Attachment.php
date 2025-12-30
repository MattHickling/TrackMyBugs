<?php

namespace Src\Classes;

class Attachment
{
    private \mysqli $conn;

    public function __construct(\mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function addAttachment()
    {
        $uploaded_at = date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("INSERT INTO attachments (bug_id, file_path, uploaded_at) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $_POST['bug_id'], $_POST['file_path'], $uploaded_at);

        return $stmt->execute();
    }
    
    public function getAllAttachments(): array
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
