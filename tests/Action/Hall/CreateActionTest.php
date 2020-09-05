<?php

namespace App\Test\Action\Hall;

use Mockery;
use App\Entity\Hall;
use MockeryAssertions;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use App\Exception\ErrorReporting;
use App\Action\Hall\CreateAction;
use App\Repository\HallRepository;

class CreateActionTest extends TestCase
{
    use MockeryAssertions;

    public function test_handle_success()
    {
        $repository = Mockery::spy(HallRepository::class);
        $repository->shouldReceive('nameReserved')
                   ->with('Main')
                   ->andReturn(false);

        $em = Mockery::spy(EntityManager::class);
        $em->shouldReceive('getRepository')
           ->with(Hall::class)
           ->andReturn($repository);

        $em->shouldReceive('persist');
        $em->shouldReceive('flush');

        $action = new CreateAction($em);
        $this->assertEquals(
            [
                'id'   => null,
                'name' => 'Main'
            ],
            $action->handle('Main')
        );

        $this->assertMockerySpy($em);
    }

    public function test_handle_failed()
    {
        $this->expectException(ErrorReporting::class);

        $repository = Mockery::spy(HallRepository::class);
        $repository->shouldReceive('nameReserved')
                   ->with('Main')
                   ->andReturn(true);

        $em = Mockery::spy(EntityManager::class);
        $em->shouldReceive('getRepository')
           ->with(Hall::class)
           ->andReturn($repository);

        $action = new CreateAction($em);
        $action->handle('Main');
    }
}