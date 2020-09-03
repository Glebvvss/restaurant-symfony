<?php

namespace App\Test\Presentation;

use DateTime;
use App\Entity\Hall;
use App\Entity\Table;
use App\Entity\Reserve;
use App\Entity\ReserveInterval;
use PHPUnit\Framework\TestCase;
use App\Presentation\ReservePresentation;

class ReservePresentationTest extends TestCase
{
    public function test_toArray()
    {
        $timeFrom = '2020-12-12 16:00';
        $timeTo   = '2020-12-12 18:00';

        $reserve = new Reserve(
            new Table(
                new Hall('Main'), 1
            ),
            new ReserveInterval(
                new DateTime($timeFrom),
                new DateTime($timeTo)
            )
        );

        $presentation = new ReservePresentation($reserve);

        $this->assertEquals(
            [
                'id'        => null,
                'time_from' => $timeFrom,
                'time_to'   => $timeTo,
            ],
            $presentation->toArray()
        );
    }
}