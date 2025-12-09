<?php

class Dashboard
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addBug($title, $description, $priority, $user)
    {
        // print_r($priority);
        $priority = intval($priority);
        $stmt = $this->conn->prepare("INSERT INTO bugs (title, description, priority, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $title, $description, $priority, $user);
        $stmt->execute();
        $result = $stmt->get_result();

    }

    public function getAllBugs()
    {
        $sql = "SELECT b.id, b.title, b.description,
                    p.name AS priority_name,
                    u.first_name,
                    s.name AS status_name
                FROM bugs b
                JOIN priorities p ON b.priority = p.id
                JOIN users u ON b.user_id = u.id
                JOIN statuses s ON b.status = s.id";

        $result = $this->conn->query($sql);
        var_dump($result);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

}
