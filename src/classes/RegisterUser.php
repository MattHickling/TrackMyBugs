<?php

class RegisterUser
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function register($first_name, $surname, $password, $email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("INSERT INTO users (first_name, surname, password_hash, email) VALUES (?, ?, ?)");
        $stmt->bind_param("ssss", $first_name, $surname, $hashedPassword, $email);
        return $stmt->execute();
    }
}
