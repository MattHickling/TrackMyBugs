<?php

namespace Src\Application\Service;

use Src\Domain\Entity\User;
use Src\Infrastructure\Repository\MySqlUserRepository;

class UserController
{
    private MySqlUserRepository $users;

    public function __construct(MySqlUserRepository $users)
    {
        $this->users = $users;
    }

    public function handleLogin(array $data): bool
    {
        $email = $data['email'];
        $password = $data['password'];

        $user = $this->users->findByEmail($email);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user->getPassword())) {
            return false;
        }

        $_SESSION['user_id'] = $user->getId();
        return true;
    }

    public function handleRegister(array $data): bool
    {
        $email = $data['email'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $user = new User(null, $email, $password);
        return $this->users->save($user);
    }
}
