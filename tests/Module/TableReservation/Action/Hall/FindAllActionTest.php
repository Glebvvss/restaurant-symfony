<?php

namespace App\Test\Module\TableReservation\Action\Hall;

use ReflectionClass;
use App\Entity\Hall;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use App\Repository\HallRepository;
use App\Module\TableReservation\Action\Hall\FindAllAction;

class FindAllActionTest extends TestCase
{
    private $action;

    public function setUp()
    {
        $class = new ReflectionClass(Hall::class);
        $property = $class->getProperty("id");
        $property->setAccessible(true);

        $hallMain = new Hall('Main');
        $property->setValue($hallMain, 1);

        $hallVIP  = new Hall('VIP');
        $property->setValue($hallVIP, 2);

        $repository = $this->createMock(HallRepository::class);
        $repository->method('findAll')->willReturn([
            $hallMain,
            $hallVIP
        ]);

        $em = $this->createMock(EntityManager::class);
        $em->method('getRepository')->willReturn($repository);

        $this->action = new FindAllAction($em);
    }

    public function test_handle()
    {
        $this->assertEquals(
            [
                [
                    'id'   => 1,
                    'name' => 'Main'
                ],
                [
                    'id'   => 2,
                    'name' => 'VIP'
                ],
            ],
            $this->action->handle()
        );
    }
}