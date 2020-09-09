<?php

namespace App\Test\Module\TableReservation\Action\Hall;

use Mockery;
use App\Module\TableReservation\Entity\Hall;
use MockeryAssertions;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use App\Module\TableReservation\Action\Hall\UpdateAction;
use App\Module\TableReservation\Repository\HallRepository;

class UpdateActionTest extends TestCase
{
    use MockeryAssertions;

    private const HALL_ID       = 1;
    private const HALL_OLD_NAME = 'VIP';
    private const HALL_NEW_NAME = 'VIP';

    public function test_handle()
    {
        $repository = Mockery::spy(HallRepository::class);
        $repository->shouldReceive('findOne')
                   ->with(static::HALL_ID)
                   ->andReturn(new Hall(static::HALL_OLD_NAME));

        $em = Mockery::spy(EntityManager::class);
        $em->shouldReceive('getRepository')
           ->with(Hall::class)
           ->andReturn($repository);
        $em->shouldReceive('flush');

        $action = new UpdateAction($em);
        $this->assertEquals(
            [
                'id'   => null,
                'name' => static::HALL_NEW_NAME
            ],
            $action->handle(static::HALL_ID, static::HALL_NEW_NAME)
        );

        $this->assertMockerySpy($em);
    }
}