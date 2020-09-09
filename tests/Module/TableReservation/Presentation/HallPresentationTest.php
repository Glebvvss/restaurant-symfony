<?php

namespace App\Test\Module\TableReservation\Presentation;

use App\Module\TableReservation\Entity\Hall;
use PHPUnit\Framework\TestCase;
use App\Module\TableReservation\Presentation\HallPresentation;

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