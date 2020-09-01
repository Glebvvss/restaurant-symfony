<?php 

namespace App\Test\Entity;

use DateTime;
use App\Entity\ReserveInterval;
use PHPUnit\Framework\TestCase;
use App\Exception\ErrorReporting;

class ReserveIntervalTest extends TestCase
{
    public function test_createWhenTimeFromGtTimeTo()
    {
        $this->expectException(ErrorReporting::class);

        $timeFrom = new DateTime('2020-08-08 18:00:00');
        $timeTo   = new DateTime('2020-08-08 16:00:00');
        new ReserveInterval($timeFrom, $timeTo);
    }

    public function test_createWhenTimeFromEqualsTimeTo()
    {
        $this->expectException(ErrorReporting::class);

        $timeFrom = new DateTime('2020-08-08 18:00:00');
        $timeTo   = new DateTime('2020-08-08 18:00:00');
        new ReserveInterval($timeFrom, $timeTo);
    }

    public function test_getTiemFrom_getTimeTo()
    {
        $timeFrom = new DateTime('2020-08-08 18:00:00');
        $timeTo   = new DateTime('2020-08-08 19:00:00');
        $reserveInterval = new ReserveInterval($timeFrom, $timeTo);

        $this->assertSame($timeFrom, $reserveInterval->getTimeFrom());
        $this->assertSame($timeTo,   $reserveInterval->getTimeTo());
    }

    public function test_intersectWith_noIntersect()
    {
        $reserveInterval1 = new ReserveInterval(
            new DateTime('2020-08-08 18:00:00'), 
            new DateTime('2020-08-08 19:00:00')
        );

        $reserveInterval2 = new ReserveInterval(
            new DateTime('2020-08-08 20:00:00'), 
            new DateTime('2020-08-08 21:00:00')
        );

        $this->assertFalse($reserveInterval1->intersectWith($reserveInterval2));
        $this->assertFalse($reserveInterval2->intersectWith($reserveInterval1));
    }

    public function test_intersectWith_neighborIntervals()
    {
        $reserveInterval1 = new ReserveInterval(
            new DateTime('2020-08-08 18:00:00'), 
            new DateTime('2020-08-08 19:00:00')
        );

        $reserveInterval2 = new ReserveInterval(
            new DateTime('2020-08-08 19:00:00'), 
            new DateTime('2020-08-08 20:00:00')
        );

        $this->assertFalse($reserveInterval1->intersectWith($reserveInterval2));
        $this->assertFalse($reserveInterval2->intersectWith($reserveInterval1));
    }

    public function test_intersectWith_equalIntervals()
    {
        $reserveInterval1 = new ReserveInterval(
            new DateTime('2020-08-08 18:00:00'), 
            new DateTime('2020-08-08 19:00:00')
        );

        $reserveInterval2 = new ReserveInterval(
            new DateTime('2020-08-08 18:00:00'), 
            new DateTime('2020-08-08 19:00:00')
        );

        $this->assertTrue($reserveInterval1->intersectWith($reserveInterval2));
        $this->assertTrue($reserveInterval2->intersectWith($reserveInterval1));
    }

    public function test_intersectWith_innerInterval()
    {
        $reserveInterval1 = new ReserveInterval(
            new DateTime('2020-08-08 18:00:00'), 
            new DateTime('2020-08-08 19:00:00')
        );

        $reserveInterval2 = new ReserveInterval(
            new DateTime('2020-08-08 18:15:00'), 
            new DateTime('2020-08-08 18:45:00')
        );

        $this->assertTrue($reserveInterval1->intersectWith($reserveInterval2));
        $this->assertTrue($reserveInterval2->intersectWith($reserveInterval1));
    }

    public function test_intersectWith_particularIntersect()
    {
        $reserveInterval1 = new ReserveInterval(
            new DateTime('2020-08-08 18:00:00'), 
            new DateTime('2020-08-08 19:00:00')
        );

        $reserveInterval2 = new ReserveInterval(
            new DateTime('2020-08-08 18:30:00'), 
            new DateTime('2020-08-08 19:30:00')
        );

        $this->assertTrue($reserveInterval1->intersectWith($reserveInterval2));
        $this->assertTrue($reserveInterval2->intersectWith($reserveInterval1));
    }
}
