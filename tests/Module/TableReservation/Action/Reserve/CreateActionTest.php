<?php

namespace App\Test\Module\TableReservation\Action\Reserve;

use Mockery;
use DateTime;
use App\Module\TableReservation\Entity\Hall;
use App\Module\TableReservation\Entity\Table;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use App\Module\TableReservation\Repository\HallRepository;
use App\Module\TableReservation\Action\Reserve\CreateAction;

class CreateActionTest extends TestCase
{
    private const CLIENT_NAME = 'John Mayer';
    private const TIME_FROM   = '2021-12-12 12:00';
    private const TIME_TO     = '2021-12-12 13:00';

    public function test_handle()
    {
        $hallId      =
        $tableNumber = 1;

        $hall  = new Hall('Main');
        $hall->addTable(new Table($tableNumber));

        $repository = Mockery::spy(HallRepository::class);
        $repository->shouldReceive('findOne')
                   ->with($hallId)
                   ->andReturn($hall);

        $em = Mockery::spy(EntityManager::class);
        $em->shouldReceive('getRepository')
           ->with(Hall::class)
           ->andReturn($repository);
        $em->shouldReceive('flush');

        $action = new CreateAction($em);
        $this->assertEquals(
            [
                'id'           => null,
                'client_name'  => static::CLIENT_NAME,
                'time_from'    => static::TIME_FROM,
                'time_to'      => static::TIME_TO
            ],
            $action->handle(
                $hallId,
                $tableNumber,
                static::CLIENT_NAME,
                new DateTime(static::TIME_FROM),
                new DateTime(static::TIME_TO)
            )
        );
    }
}