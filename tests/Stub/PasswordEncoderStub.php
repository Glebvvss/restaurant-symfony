<?php

namespace App\Test\Stub;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordEncoderStub implements UserPasswordEncoderInterface
{
    public function encodePassword(UserInterface $user, string $plainPassword)
    {
        return $plainPassword;
    }

    public function isPasswordValid(UserInterface $user, string $raw)
    {
    }

    public function needsRehash(UserInterface $user): bool
    {
        return false;
    }
}