<?php

namespace Src\Classes;

class Journal
{
    private \mysqli $conn;

    public function __construct(\mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function create(int $user_id, string $entry, string $description): void
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO dev_journal (user_id, entry, description) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("iss", $user_id, $entry, $description);
        $stmt->execute();
    }

    public function getAllJournals(int $user_id): array
    {
        $stmt = $this->conn->prepare(
            "SELECT dj.id, dj.entry, dj.description, dj.created_at, 
                    CONCAT(u.first_name, ' ', u.surname) AS added_by
            FROM dev_journal dj
            JOIN users u ON dj.user_id = u.id
            WHERE dj.user_id = ?
            ORDER BY dj.created_at DESC"
        );
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getJournalById(int $id, int $user_id): ?array
    {
        $stmt = $this->conn->prepare(
            "SELECT dj.id, dj.entry, dj.description, dj.created_at, 
                    CONCAT(u.first_name, ' ', u.surname) AS added_by
            FROM dev_journal dj
            JOIN users u ON dj.user_id = u.id
            WHERE dj.id = ? AND dj.user_id = ?"
        );
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

}
