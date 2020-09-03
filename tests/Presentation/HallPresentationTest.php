<?php

namespace App\Test\Presentation;

use App\Entity\Hall;
use PHPUnit\Framework\TestCase;
use App\Presentation\HallPresentation;

class HallPresentationTest extends TestCase
{
    public function test_toArray()
    {
        $hallName = 'Main';
        $presentation = new HallPresentation(
            new Hall($hallName)
        );

        $this->assertEquals(
            [
                'id'   => null,
                'name' => $hallName
            ],
            $presentation->toArray()
        );
    }
}