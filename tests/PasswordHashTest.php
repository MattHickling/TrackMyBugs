<?php

use PHPUnit\Framework\TestCase;

class PasswordHashTest extends TestCase
{
    public function testPasswordHashVerification()
    {
        $password = 'MySecurePassword';
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->assertTrue(password_verify($password, $hash));
        $this->assertFalse(password_verify('wrong-password', $hash));
    }
}
