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
        $sql = "SELECT 
                    b.id,
                    b.title,
                    b.description,
                    b.priority AS priority_name,
                    b.status AS status_name,
                    u.first_name
                FROM bugs b
                LEFT JOIN users u ON u.id = b.user_id
                ORDER BY b.id DESC";

        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }


}
