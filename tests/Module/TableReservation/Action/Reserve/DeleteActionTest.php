<?php

namespace App\Test\Module\TableReservation\Action\Reserve;

use Mockery;
use DateTime;
use MockeryAssertions;
use App\Module\TableReservation\Entity\Reserve;
use App\Module\TableReservation\Entity\ReserveInterval;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use App\Module\TableReservation\Action\Reserve\DeleteAction;
use App\Module\TableReservation\Repository\ReserveRepository;

class DeleteActionTest extends TestCase
{
    use MockeryAssertions;

    private const RESERVE_ID  = 1;
    private const CLIENT_NAME = 'John Mayer';
    private const TIME_FROM   = '2021-12-12 12:00';
    private const TIME_TO     = '2021-12-12 13:00';

    public function test_handle()
    {
        $reserve = new Reserve(
            static::CLIENT_NAME,
            new ReserveInterval(
                new DateTime(static::TIME_FROM),
                new DateTime(static::TIME_TO)
            )
        );

        $repository = Mockery::spy(ReserveRepository::class);
        $repository->shouldReceive('findOne')
                   ->with(static::RESERVE_ID)
                   ->andReturn($reserve);

        $em = Mockery::spy(EntityManager::class);
        $em->shouldReceive('getRepository')
           ->with(Reserve::class)
           ->andReturn($repository);
        $em->shouldReceive('remove');
        $em->shouldReceive('flush');

        $action = new DeleteAction($em);
        $action->handle(static::RESERVE_ID);

        $this->assertMockerySpy($repository);
        $this->assertMockerySpy($em);
    }
}