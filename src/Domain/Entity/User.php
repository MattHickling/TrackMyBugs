<?php

namespace TrackMyBugs\Domiam\Entities;

class User
{
private $id;
private $email;
private $passwordHash;

    public function __construct($id, $email, $passwordHash)
    {
        $this->id = $id;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }
    
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }
}