<?php

namespace App\Test\Module\Authentication\Entity;

use PHPUnit\Framework\TestCase;
use App\Common\Exception\ErrorReporting;
use App\Module\Authentication\Entity\Password;
use App\Module\Authentication\Entity\PasswordHash;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordHashTest extends TestCase
{
    const CORRECT_PASSWORD   = 'password';
    const STUB_PASSWORD_HASH = 'password';

    public function test_toString()
    {
        $passwordHash = new PasswordHash(
            new Password(self::CORRECT_PASSWORD),
            $this->passwordEncoderStub()
        );

        $this->assertSame(
            (string) $passwordHash,
            self::STUB_PASSWORD_HASH
        );
    }

    private function passwordEncoderStub()
    {
        return new class() implements UserPasswordEncoderInterface
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
        };
    }
}