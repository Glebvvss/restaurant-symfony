<?php

namespace App\Test\Action\Table;

use Mockery;
use App\Entity\Hall;
use MockeryAssertions;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use App\Action\Table\CreateAction;
use App\Repository\HallRepository;

class CreateActionTest extends TestCase
{
    use MockeryAssertions;

    public function test_handle()
    {
        $hallId      =
        $tableNumber = 1;

        $repository = Mockery::spy(HallRepository::class);
        $repository->shouldReceive('findOne')
                   ->with($hallId)
                   ->andReturns(new Hall('Main'));

        $em = Mockery::spy(EntityManager::class);
        $em->shouldReceive('getRepository')
           ->with(Hall::class)
           ->andReturns($repository);
        $em->shouldReceive('flush');

        $action = new CreateAction($em);
        $this->assertEquals(
            [
                'number' => 1
            ],
            $action->handle($hallId, $tableNumber)
        );

        $this->assertMockerySpy($repository);
        $this->assertMockerySpy($em);
    }
}