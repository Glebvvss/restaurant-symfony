<?php

namespace App\Test\Module\Authentication\Entity;

require_once __DIR__ . '/../../../Stub/PasswordEncoderStub.php';

use PHPUnit\Framework\TestCase;
use App\Test\Stub\PasswordEncoderStub;
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
            new PasswordEncoderStub()
        );

        $this->assertSame(
            (string) $passwordHash,
            self::STUB_PASSWORD_HASH
        );
    }
}