<?php

include_once __DIR__ . '/../config/config.php';

class User
{ 
    public function __construct(private $db)
    {
         $this->db = $dbConnection;
    }

    public function getUserById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUserEmail($id, $newEmail)
    {
        $stmt = $this->db->prepare("UPDATE users SET email = :email WHERE id = :id");
        $stmt->bindParam(':email', $newEmail);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteUser($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

}