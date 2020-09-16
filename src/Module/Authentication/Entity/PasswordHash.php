<?php

namespace App\Module\Authentication\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface as PasswordEncoder;

class PasswordHash
{
    private Password        $password;
    private PasswordEncoder $passwordEncoder;

    public function __construct(
        Password        $password, 
        PasswordEncoder $passwordEncoder
    )
    {
        $this->password        = $password;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function __toString(): string
    {
        return $this->passwordEncoder->encodePassword(
            $this->stubUserObject(),
            $this->password
        );
    }

    private function stubUserObject()
    {
        return new class() implements UserInterface {
            public function getRoles() {}
            public function getPassword() {}
            public function getSalt() {}
            public function getUsername() {}
            public function eraseCredentials() {}
        };
    }
}