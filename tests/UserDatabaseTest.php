<?php

use PHPUnit\Framework\TestCase;

class UserDatabaseTest extends TestCase
{
    private \mysqli $db;

    protected function setUp(): void
    {
        \mysqli_report(\MYSQLI_REPORT_ERROR | \MYSQLI_REPORT_STRICT);

        $host = getenv('DB_HOST');
        $user = getenv('DB_USERNAME');
        $pass = getenv('DB_PASSWORD');
        $db   = getenv('DB_DATABASE');
        $port = (int) getenv('DB_PORT');

        if (!$host || !$user || !$db) {
            throw new \RuntimeException('Database environment variables not set');
        }

        $this->db = new \mysqli(
            $host,
            $user,
            $pass,
            $db,
            $port
        );

        $this->db->set_charset('utf8mb4');
        $this->db->begin_transaction();
    }

    protected function tearDown(): void
    {
        $this->db->rollback();
        $this->db->close();
    }

    public function testUserCanBeInsertedIntoDatabase()
    {
        $firstName = 'Test';
        $surname = 'User';
        $email = 'testuser@example.com';
        $password = 'secret123';

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare(
            'INSERT INTO users 
            (first_name, surname, email, password_hash, created_at)
            VALUES (?, ?, ?, ?, NOW())'
        );

        $stmt->bind_param(
            'ssss',
            $firstName,
            $surname,
            $email,
            $hash
        );

        $this->assertTrue($stmt->execute());

        $stmt = $this->db->prepare(
            'SELECT first_name, surname, email 
             FROM users WHERE email = ?'
        );

        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $this->assertNotNull($user);
        $this->assertEquals($firstName, $user['first_name']);
        $this->assertEquals($surname, $user['surname']);
        $this->assertEquals($email, $user['email']);
    }
}
