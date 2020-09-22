<?php

namespace App\Tests\Module\Authentication\Action;

require_once __DIR__ . '/../../../Stub/PasswordEncoderStub.php';
require_once __DIR__ . '/../../../Stub/TokenFactoryStub.php';

use Mockery;
use MockeryAssertions;
use PHPUnit\Framework\TestCase;
use App\Test\Stub\TokenFactoryStub;
use App\Test\Stub\PasswordEncoderStub;
use App\Common\Exception\ErrorReporting;
use Doctrine\ORM\EntityManagerInterface;
use App\Module\Authentication\Entity\User;
use App\Module\Authentication\Entity\Email;
use App\Module\Authentication\Entity\Username;
use App\Module\Authentication\Entity\Password;
use App\Module\Authentication\Action\LoginAction;
use App\Module\Authentication\Entity\PasswordHash;
use App\Module\Authentication\Repository\UserRepository;

class LoginActionTest extends TestCase
{
    use MockeryAssertions;

    const TOKEN               = 'token';
    const USERNAME            = 'John';
    const EMAIL               = 'john@mayer.com';
    const PASSWORD            = 'password';
    const NEW_PASSWORD        = 'new-password';
    const NO_CURRENT_PASSWORD = 'no-current-password';

    private LoginAction $action;

    protected function setUp()
    {
        $this->action = new LoginAction(
            $this->entityManagerMock(
                $this->userRepositoryMock()
            ),
            new TokenFactoryStub(self::TOKEN),
            new PasswordEncoderStub()
        );
    }

    public function test_handle_success()
    {
        $this->assertEquals(
            ['token' => self::TOKEN], 
            $this->action->handle(self::USERNAME, self::PASSWORD)
        );
    }

    public function test_handle_fail()
    {
        $this->expectException(ErrorReporting::class);
        $this->action->handle(self::USERNAME, self::NO_CURRENT_PASSWORD);
    }

    private function userRepositoryMock()
    {
        $user = new User(
            new Username(self::USERNAME),
            new Email(self::EMAIL),
            new PasswordHash(
                new Password(self::PASSWORD),
                new PasswordEncoderStub()
            )
        );

        $repository = Mockery::mock(UserRepository::class);
        $repository
            ->shouldReceive('findOneByUsername')
            ->with(Mockery::on(
                fn($username) => new Username(self::USERNAME) == $username
            ))
            ->andReturns($user);
        return $repository;
    }

    private function entityManagerMock($repository)
    {
        $em = Mockery::mock(EntityManagerInterface::class);
        $em->shouldReceive('getRepository')
           ->with(User::class)
           ->andReturns($repository);
        return $em;
    }
}