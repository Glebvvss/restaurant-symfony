<?php

namespace App\Tests\Module\Authentication\Action;

require_once __DIR__ . '/../../../Stub/PasswordEncoderStub.php';

use Mockery;
use MockeryAssertions;
use PHPUnit\Framework\TestCase;
use App\Test\Stub\PasswordEncoderStub;
use Doctrine\ORM\EntityManagerInterface;
use App\Module\Authentication\Entity\User;
use App\Module\Authentication\Action\RegisterAction;
use App\Module\Authentication\Repository\UserRepository;

class RegisterActionTest extends TestCase
{
    use MockeryAssertions;

    const USERNAME = 'John';
    const EMAIL    = 'john@mayer.com';
    const PASSWORD = 'password';

    public function test_execute_success()
    {
        $repository = Mockery::spy(UserRepository::class);
        $repository->shouldReceive('persist');

        $em = Mockery::spy(EntityManagerInterface::class);
        $em->shouldReceive('flush');
        $em->shouldReceive('getRepository')
           ->with(User::class)
           ->andReturn($repository);

        $action = new RegisterAction(
            new PasswordEncoderStub(),
            $em
        );

        $action->handle(
            self::USERNAME,
            self::PASSWORD,
            self::EMAIL
        );

        $this->assertMockerySpy($repository);
        $this->assertMockerySpy($em);
    }
}