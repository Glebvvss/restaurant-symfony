<?php

namespace App\Test\Module\TableReservation\Action\Table;

use Mockery;
use App\Entity\Hall;
use App\Entity\Table;
use MockeryAssertions;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use App\Module\TableReservation\Action\Table\DeleteAction;
use App\Repository\HallRepository;

class DeleteActionTest extends TestCase
{
    use MockeryAssertions;

    public function test_handle()
    {
        $hallId      =
        $tableNumber = 1;

        $hall = new Hall('Main');
        $hall->addTable(new Table(1));

        $repository = Mockery::spy(HallRepository::class);
        $repository->shouldReceive('findOne')
                   ->with($hallId)
                   ->andReturns($hall);

        $em = Mockery::spy(EntityManager::class);
        $em->shouldReceive('getRepository')
           ->with(Hall::class)
           ->andReturns($repository);
        $em->shouldReceive('remove');
        $em->shouldReceive('flush');

        new DeleteAction($em);
        $this->assertMockerySpy($repository);
        $this->assertMockerySpy($em);
    }
}