<?php

namespace Src\Classes;

class Attachment
{
    private \mysqli $conn;

    public function __construct(\mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function addAttachment(int $bugId, string $filePath): bool
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO attachments (bug_id, file_path)
             VALUES (?, ?)"
        );

        $stmt->bind_param("is", $bugId, $filePath);
        return $stmt->execute();
    }

    public function getAttachmentsByBug(int $bugId): array
    {
        $stmt = $this->conn->prepare(
            "SELECT file_path, uploaded_at
             FROM attachments
             WHERE bug_id = ?
             ORDER BY uploaded_at ASC"
        );

        $stmt->bind_param("i", $bugId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
