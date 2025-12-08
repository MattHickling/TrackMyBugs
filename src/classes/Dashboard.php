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
}
