<?php

class Bug
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    
    public function getBug($bug_id) 
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
                WHERE b.id = ?
                ORDER BY b.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $bug_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }


}
