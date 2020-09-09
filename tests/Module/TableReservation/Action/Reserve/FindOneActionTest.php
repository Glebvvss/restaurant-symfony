<?php

namespace App\Test\Module\TableReservation\Action\Reserve;

use Mockery;
use DateTime;
use ReflectionClass;
use App\Module\TableReservation\Entity\Hall;
use App\Module\TableReservation\Entity\Table;
use App\Module\TableReservation\Entity\Reserve;
use App\Module\TableReservation\Entity\ReserveInterval;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use App\Module\TableReservation\Action\Reserve\FindOneAction;
use App\Module\TableReservation\Repository\ReserveRepository;

class FindOneActionTest extends TestCase
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

        $repository = Mockery::spy(ReserveRepository::class);
        $repository->shouldReceive('findOne')
                   ->with(static::RESERVE_ID)
                   ->andReturn($reserve);

        $em = Mockery::spy(EntityManager::class);
        $em->shouldReceive('getRepository')
           ->with(Reserve::class)
           ->andReturn($repository);

        $action = new FindOneAction($em);
        $this->assertEquals(
            [
                'id'           => null,
                'hall_id'      => static::HALL_ID,
                'table_number' => static::TABLE_NUMBER,
                'client_name'  => static::CLIENT_NAME,
                'time_from'    => static::TIME_FROM,
                'time_to'      => static::TIME_TO
            ],
            $action->handle(static::RESERVE_ID)
        );
    }
}