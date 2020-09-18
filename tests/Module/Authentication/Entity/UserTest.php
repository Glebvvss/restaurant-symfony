<?php

namespace App\Test\Module\Authentication\Entity;

require_once __DIR__ . '/../../../Stub/PasswordEncoderStub.php';

use PHPUnit\Framework\TestCase;
use App\Test\Stub\PasswordEncoderStub;
use App\Common\Exception\ErrorReporting;
use App\Module\Authentication\Entity\User;
use App\Module\Authentication\Entity\Email;
use App\Module\Authentication\Entity\Username;
use App\Module\Authentication\Entity\Password;
use App\Module\Authentication\Entity\PasswordHash;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserTest extends TestCase
{
    const USERNAME          = 'John';
    const EMAIL             = 'john@mayer.com';
    const PASSWORD          = 'password';
    const NEW_PASSWORD      = 'new-password';
    const NEW_PASSWORD_HASH = 'new-password';

    public function test_common()
    {
        $username = new Username(self::USERNAME);
        $email    = new Email(self::EMAIL);
        $password = new PasswordHash(
            new Password(self::PASSWORD),
            new PasswordEncoderStub()
        );

        $user = new User(
            $username,
            $email,
            $password
        );

        $this->assertSame($user->getUsername(), $username);
        $this->assertSame($user->getEmail(),    $email);
        $this->assertSame($user->getPassword(), (string) $password);
    }

    public function test_changePassword_success()
    {
        $user = new User(
            new Username(self::USERNAME),
            new Email(self::EMAIL),
            new PasswordHash(
                new Password(self::PASSWORD),
                new PasswordEncoderStub()
            )
        );

        $user->changePassword(
            new PasswordHash(
                new Password(self::PASSWORD),
                new PasswordEncoderStub()
            ),
            new PasswordHash(
                new Password(self::NEW_PASSWORD),
                new PasswordEncoderStub()
            )
        );

        $this->assertSame($user->getPassword(), self::NEW_PASSWORD_HASH);
    }

    public function test_changePassword_failedWithIncorrectCurrentPassword()
    {
        $this->expectException(ErrorReporting::class);

        $user = new User(
            new Username(self::USERNAME),
            new Email(self::EMAIL),
            new PasswordHash(
                new Password(self::PASSWORD),
                new PasswordEncoderStub()
            )
        );

        $user->changePassword(
            new PasswordHash(
                new Password('Incorrect current password'),
                new PasswordEncoderStub()
            ),
            new PasswordHash(
                new Password(self::NEW_PASSWORD),
                new PasswordEncoderStub()
            )
        );
    }
}