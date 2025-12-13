<?php

class Comment
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function createComment(
        int $bug_id,
        int $user_id,
        string $comment
    ): bool {
        $stmt = $this->conn->prepare(
            "INSERT INTO comments (bug_id, user_id, comment) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("iis", $bug_id, $user_id, $comment);
        return $stmt->execute();
    }

    public function getComments(): array
    {
        $sql = "SELECT
                    c.id,
                    c.bug_id,
                    c.comment,
                    c.created_at,
                    u.first_name AS added_by
                FROM comments c
                JOIN bugs b ON c.bug_id = b.id
                LEFT JOIN users u ON u.id = c.user_id
                ORDER BY c.id DESC";

        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getCommentById(int $id): ?array
    {
        $stmt = $this->conn->prepare(
            "SELECT c.id, c.bug_id, c.comment, c.created_at, u.first_name AS added_by
            FROM comments c
            LEFT JOIN users u ON c.user_id = u.id
            WHERE c.id = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

}
