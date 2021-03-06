<?php

namespace App\Test\Module\TableReservation\Action\Hall;

use Mockery;
use App\Module\TableReservation\Entity\Hall;
use MockeryAssertions;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use App\Common\Exception\ErrorReporting;
use App\Module\TableReservation\Action\Hall\CreateAction;
use App\Module\TableReservation\Repository\HallRepository;

class CreateActionTest extends TestCase
{
    use MockeryAssertions;

    public function test_handle()
    {
        $repository = Mockery::spy(HallRepository::class);
        $repository->shouldReceive('persist')
                   ->with('Main');

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
}