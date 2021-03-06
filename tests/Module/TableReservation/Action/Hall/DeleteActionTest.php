<?php

namespace App\Test\Module\TableReservation\Action\Hall;

use Mockery;
use App\Module\TableReservation\Entity\Hall;
use ReflectionClass;
use MockeryAssertions;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use App\Module\TableReservation\Action\Hall\DeleteAction;
use App\Module\TableReservation\Repository\HallRepository;

class DeleteActionTest extends TestCase
{
    use MockeryAssertions;

    public function test_handle()
    {
        $class = new ReflectionClass(Hall::class);
        $property = $class->getProperty("id");
        $property->setAccessible(true);

        $hall = new Hall('Main');
        $property->setValue($hall, 1);

        $repository = Mockery::mock(HallRepository::class);
        $repository->shouldReceive('findOne')
                   ->with(1)
                   ->once()
                   ->andReturn($hall);

        $em = Mockery::spy(EntityManager::class);
        $em->shouldReceive('getRepository')
           ->with(Hall::class)
           ->once()
           ->andReturn($repository);

        $action = new DeleteAction($em);
        $action->handle(1);

        $this->assertMockerySpy($em);
    }
}