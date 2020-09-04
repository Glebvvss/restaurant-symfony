<?php

namespace App\Test\Action\Hall;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use App\Action\Hall\CreateAction;

class CreateActionTest extends TestCase
{
    private $action;

    public function setUp()
    {
        $em = $this->createMock(EntityManager::class);
        $this->action = new CreateAction($em);
    }

    public function test_handle()
    {
        $this->assertEquals(
            [
                'id'   => null,
                'name' => 'Main'
            ],
            $this->action->handle('Main')
        );
    }
}