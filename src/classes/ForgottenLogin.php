<?php

class ForgottenLogin
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function forgotten($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = $email");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return false;
            echo "An email has been sent with instructions to reset your password.";
        }

       
    }
}
