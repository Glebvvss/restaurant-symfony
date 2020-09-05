<?php

namespace App\Test\Entity;

use DateTime;
use App\Entity\Reserve;
use App\Entity\ReserveInterval;
use PHPUnit\Framework\TestCase;
use App\Exception\ErrorReporting;

class ReserveTest extends TestCase
{
    public function test_createWhenTimeFromGtTimeTo()
    {
        $this->expectException(ErrorReporting::class);

        new Reserve(
            new ReserveInterval(
                new DateTime('2020-08-12 18:00:00'),
                new DateTime('2020-08-12 16:00:00')
            )
        );
    }

    public function test_createWhenTimeFromEqualsTimeTo()
    {
        $this->expectException(ErrorReporting::class);

        new Reserve(
            new ReserveInterval(
                new DateTime('2020-08-12 18:00:00'),
                new DateTime('2020-08-12 18:00:00')
            )
        );
    }

    public function test_getTimeFrom_getTimeTo()
    {
        $timeFrom = new DateTime('2020-08-12 18:00:00');
        $timeTo   = new DateTime('2020-08-12 20:00:00');
        $reserve  = new Reserve(new ReserveInterval($timeFrom, $timeTo));

        $this->assertSame($timeFrom, $reserve->getTimeFrom());
        $this->assertSame($timeTo,   $reserve->getTimeTo());
    }
}