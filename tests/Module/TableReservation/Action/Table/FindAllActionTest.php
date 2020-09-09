<?php

namespace App\Test\Module\TableReservation\Action\Table;

use ReflectionClass;
use App\Entity\Hall;
use App\Entity\Table;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use App\Repository\HallRepository;
use App\Module\TableReservation\Action\Table\FindAllAction;

class FindAllActionTest extends TestCase
{
    private $action;

    public function setUp()
    {
        $class = new ReflectionClass(Hall::class);
        $property = $class->getProperty("id");
        $property->setAccessible(true);

        $hall = new Hall('Main');
        $property->setValue($hall, 1);

        $hall->addTable(new Table(1));
        $hall->addTable(new Table(2));

        $repository = $this->createMock(HallRepository::class);
        $repository->method('findOne')->willReturn($hall);

        $em = $this->createMock(EntityManager::class);
        $em->method('getRepository')->willReturn($repository);

        $this->action = new FindAllAction($em);
    }

    public function test_handle()
    {
        $this->assertEquals(
            [
                [
                    'number' => 1
                ],
                [
                    'number' => 2
                ],
            ],
            $this->action->handle(1)
        );
    }
}