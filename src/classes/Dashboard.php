<?php

class Dashboard
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addBug($title, $description, $priority, $bug_url, $user)
    {
        // print_r($priority);
        $priority = intval($priority);
        $stmt = $this->conn->prepare("INSERT INTO bugs (title, description, priority, bug_url, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisi", $title, $description, $priority, $bug_url, $user);
        $stmt->execute();
        $result = $stmt->get_result();

    }
    
    public function getAllBugs() 
    {
        $sql = "SELECT 
                    b.id,
                    b.title,
                    b.description,
                    b.priority AS priority_name,
                    b.status AS status_name,
                    u.first_name,
                    b.bug_url,
                    b.created_at
                FROM bugs b
                LEFT JOIN users u ON u.id = b.user_id
                ORDER BY b.id DESC";

        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }


}
