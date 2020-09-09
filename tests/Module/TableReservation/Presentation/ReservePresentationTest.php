<?php

namespace App\Test\Module\TableReservation\Presentation;

use DateTime;
use App\Module\TableReservation\Entity\Reserve;
use App\Module\TableReservation\Entity\ReserveInterval;
use PHPUnit\Framework\TestCase;
use App\Module\TableReservation\Presentation\ReservePresentation;

class ReservePresentationTest extends TestCase
{
    public function test_toArray()
    {
        $name     = 'John Mayer';
        $timeFrom = '2020-12-12 16:00';
        $timeTo   = '2020-12-12 18:00';

        $reserve = new Reserve(
            $name,
            new ReserveInterval(
                new DateTime($timeFrom),
                new DateTime($timeTo)
            )
        );

        $presentation = new ReservePresentation($reserve);

        $this->assertEquals(
            [
                'id'          => null,
                'client_name' => $name,
                'time_from'   => $timeFrom,
                'time_to'     => $timeTo,
            ],
            $presentation->toArray()
        );
    }
}