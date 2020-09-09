<?php

namespace App\Test\Module\TableReservation\Action\Reserve;

use Mockery;
use DateTime;
use ReflectionClass;
use App\Entity\Hall;
use App\Entity\Table;
use App\Entity\Reserve;
use App\Entity\ReserveInterval;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use App\Repository\HallRepository;
use App\Module\TableReservation\Action\Reserve\FindActualByTableAction;

class FindActiveByTableActionTest extends TestCase
{
    private const HALL_ID      = 1;
    private const TABLE_NUMBER = 1;
    private const RESERVE_ID   = 1;
    private const CLIENT_NAME  = 'John Mayer';
    private const TIME_FROM    = '2021-12-12 12:00';
    private const TIME_TO      = '2021-12-12 13:00';

    public function test_handle()
    {
        $hall  = new Hall('Main');
        $class = new ReflectionClass(Hall::class);
        $property = $class->getProperty("id");
        $property->setAccessible(true);
        $property->setValue($hall, static::HALL_ID);

        $reserve = new Reserve(
            static::CLIENT_NAME,
            new ReserveInterval(
                new DateTime(static::TIME_FROM),
                new DateTime(static::TIME_TO)
            )
        );

        $table = new Table(1);
        $table->addReserve($reserve);
        $hall->addTable($table);

        $repository = Mockery::spy(HallRepository::class);
        $repository->shouldReceive('findOne')
                   ->with(static::HALL_ID)
                   ->andReturn($hall);

        $em = Mockery::spy(EntityManager::class);
        $em->shouldReceive('getRepository')
           ->with(Hall::class)
           ->andReturn($repository);

        $action = new FindActualByTableAction($em);
        $this->assertEquals(
            [
                [
                    'id'           => null,
                    'client_name'  => static::CLIENT_NAME,
                    'time_from'    => static::TIME_FROM,
                    'time_to'      => static::TIME_TO
                ]
            ],
            $action->handle(static::RESERVE_ID, static::TABLE_NUMBER)
        );
    }
}