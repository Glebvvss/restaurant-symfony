<?php

namespace App\Tests\Module\Authentication\Action;

require_once __DIR__ . '/../../../Stub/PasswordEncoderStub.php';

use Mockery;
use MockeryAssertions;
use PHPUnit\Framework\TestCase;
use App\Test\Stub\PasswordEncoderStub;
use App\Common\Exception\ErrorReporting;
use Doctrine\ORM\EntityManagerInterface;
use App\Module\Authentication\Entity\User;
use App\Module\Authentication\Entity\Email;
use App\Module\Authentication\Entity\Username;
use App\Module\Authentication\Entity\Password;
use App\Module\Authentication\Entity\PasswordHash;
use App\Module\Authentication\Repository\UserRepository;
use App\Module\Authentication\Action\ChangePasswordAction;

class ChangePasswordActionTest extends TestCase
{
    use MockeryAssertions;

    const USERNAME            = 'John';
    const EMAIL               = 'john@mayer.com';
    const PASSWORD            = 'password';
    const NEW_PASSWORD        = 'new-password';
    const NO_CURRENT_PASSWORD = 'no-current-password';

    public function test_handle_success()
    {
        $repository = $this->repositorySpy();
        $em         = $this->entityManagerSpy($repository);

        $action = new ChangePasswordAction(
            new PasswordEncoderStub(), 
            $em
        );

        $action->handle(
            self::USERNAME,
            self::PASSWORD,
            self::NEW_PASSWORD,
        );

        $this->assertMockerySpy($repository);
        $this->assertMockerySpy($em);
    }

    public function test_handle_fail()
    {
        $this->expectException(ErrorReporting::class);

        $action = new ChangePasswordAction(
            new PasswordEncoderStub(), 
            $this->entityManagerSpy(
                $this->repositorySpy()
            )
        );

        $action->handle(
            self::USERNAME,
            self::NO_CURRENT_PASSWORD,
            self::NEW_PASSWORD,
        );
    }

    private function repositorySpy()
    {
        $user = new User(
            new Username(self::USERNAME),
            new Email(self::EMAIL),
            new PasswordHash(
                new Password(self::PASSWORD),
                new PasswordEncoderStub()
            )
        );

        $repository = Mockery::spy(UserRepository::class);
        $repository->shouldReceive('findOneByUsername')
                   ->with(Mockery::on(
                       fn($username) => new Username(self::USERNAME) == $username
                   ))
                   ->andReturns($user);
        return $repository;
    }

    private function entityManagerSpy($repository)
    {
        $em = Mockery::spy(EntityManagerInterface::class);
        $em->shouldReceive('flush');
        $em->shouldReceive('getRepository')
           ->with(User::class)
           ->andReturns($repository);
        return $em;
    }
}