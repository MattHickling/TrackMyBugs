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
            "INSERT INTO dev_journal (user_id, entry, description, created_at)
             VALUES (?, ?, ?, NOW())"
        );
        $stmt->bind_param("iss", $user_id, $entry, $description);
        $stmt->execute();
    }

    public function getJournalById(int $id): ?array
    {
        $stmt = $this->conn->prepare(
            "SELECT dj.*, CONCAT(u.first_name, ' ', u.surname) AS added_by
            FROM dev_journal dj
            LEFT JOIN users u ON dj.user_id = u.id
            WHERE dj.id = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ?: null;
    }

    public function getAllJournals(): array
    {
        $result = $this->conn->query(
            "SELECT dj.*, CONCAT(u.first_name, ' ', u.surname) AS added_by
            FROM dev_journal dj
            LEFT JOIN users u ON dj.user_id = u.id
            ORDER BY dj.created_at DESC"
        );

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

}
