<?php

namespace App\Test\Entity;

use DateTime;
use App\Entity\Hall;
use App\Entity\Table;
use App\Entity\Reserve;
use App\Entity\ReserveInterval;
use PHPUnit\Framework\TestCase;
use App\Exception\ErrorReporting;

class ReserveTest extends TestCase
{
    public function test_createWhenTimeFromGtTimeTo()
    {
        $this->expectException(ErrorReporting::class);

        $hall  = new Hall('Main');
        $table = new Table($hall, 1);

        $reserveInterval = new ReserveInterval(
            new DateTime('2020-08-12 18:00:00'),
            new DateTime('2020-08-12 16:00:00')
        );

        new Reserve($table, $reserveInterval);
    }

    public function test_createWhenTimeFromEqualsTimeTo()
    {
        $this->expectException(ErrorReporting::class);

        $hall  = new Hall('Main');
        $table = new Table($hall, 1);

        $reserveInterval = new ReserveInterval(
            new DateTime('2020-08-12 18:00:00'),
            new DateTime('2020-08-12 18:00:00')
        );

        new Reserve($table, $reserveInterval);
    }

    public function test_getTimeFrom_getTimeTo()
    {
        $hall = new Hall('Main');
        $table = new Table($hall, 1);

        $timeFrom = new DateTime('2020-08-12 18:00:00');
        $timeTo   = new DateTime('2020-08-12 20:00:00');
        $reserveInterval = new ReserveInterval($timeFrom, $timeTo);
        $reserve  = new Reserve($table, $reserveInterval);

        $this->assertSame($timeFrom, $reserve->getTimeFrom());
        $this->assertSame($timeTo,   $reserve->getTimeTo());
    }
}