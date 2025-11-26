<?php

namespace Src\Infrastructure\Repository;

use PDO;
use Src\Domain\Entity\User;
use Src\Domain\Repository\UserRepositoryInterface;

class MyUserRepository implements UserRepositoryInterface
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new User($row['id'], $row['email'], $row['password']);
    }

    public function save(User $user): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO users (email, password) VALUES (?, ?)'
        );

        return $stmt->execute([$user->getEmail(), $user->getPassword()]);
    }
}
