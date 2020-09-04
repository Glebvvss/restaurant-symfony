<?php

namespace App\Test\Action\Hall;

use ReflectionClass;
use App\Entity\Hall;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use App\Repository\HallRepository;
use App\Action\Hall\FindOneAction;

class FindOneActionTest extends TestCase
{
    private $action;

    public function setUp()
    {
        $hall  = new Hall('Main');
        $class = new ReflectionClass(Hall::class);
        $property = $class->getProperty("id");
        $property->setAccessible(true);
        $property->setValue($hall, 1);

        $repository = $this->createMock(HallRepository::class);
        $repository->method('findOne')->willReturn($hall);

        $em = $this->createMock(EntityManager::class);
        $em->method('getRepository')->willReturn($repository);

        $this->action = new FindOneAction($em);
    }

    public function test_handle()
    {
        $this->assertEquals(
            [
                'id'   => 1,
                'name' => 'Main'
            ],
            $this->action->handle(1)
        );
    }
}