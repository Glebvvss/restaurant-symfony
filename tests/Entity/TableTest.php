<?php

namespace App\Test\Entity;

use DateTime;
use App\Entity\Table;
use App\Entity\Reserve;
use App\Entity\ReserveInterval;
use PHPUnit\Framework\TestCase;
use App\Exception\ErrorReporting;

class TableTest extends TestCase
{
    public function test_getNumber()
    {
        $table = new Table(1);
        $this->assertEquals(1, $table->getNumber());
    }

    public function test_reserves()
    {
        $table = new Table(1);
        $reserve = new Reserve(
            new ReserveInterval(
                new DateTime('2020-08-12 18:00:00'),
                new DateTime('2020-08-12 20:00:00')
            )
        );

        $table->addReserve($reserve);
        $reserves = $table->getReserves();
        $this->assertEquals(1, $reserves->count());
    }

    public function test_removeNotExistingReserve()
    {
        $this->expectException(ErrorReporting::class);

        $table = new Table(1);
        $reserve = new Reserve(
            new ReserveInterval(
                new DateTime('2020-08-12 18:00:00'),
                new DateTime('2020-08-12 20:00:00')
            )
        );

        $table->removeReserve($reserve);
    }

    public function test_removeExistingReserve()
    {
        $table = new Table(1);
        $reserve = new Reserve(
            new ReserveInterval(
                new DateTime('2020-08-12 18:00:00'),
                new DateTime('2020-08-12 20:00:00')
            )
        );

        $table->addReserve($reserve);
        $reserves = $table->getReserves();
        $this->assertSame($reserve, $reserves[0]);
        $this->assertSame(1, $reserves->count());

        $table->removeReserve($reserve);
        $reserves = $table->getReserves();
        $this->assertSame(0, $reserves->count());
    }

    public function test_intersectWith_noIntersect()
    {
        $table = new Table(1);
        $reserve1 = new Reserve(
            new ReserveInterval(
                new DateTime('2020-08-12 18:00:00'),
                new DateTime('2020-08-12 20:00:00')
            )
        );

        $reserve2 = new Reserve(
            new ReserveInterval(
                new DateTime('2020-08-12 20:00:00'),
                new DateTime('2020-08-12 21:00:00')
            )
        );

        $this->assertFalse($reserve1->intersectWith($reserve2));
        $this->assertFalse($reserve2->intersectWith($reserve1));
    }

    public function test_intersectWith_intersect()
    {
        $table = new Table(1);
        $reserve1 = new Reserve(
            new ReserveInterval(
                new DateTime('2020-08-12 18:00:00'),
                new DateTime('2020-08-12 20:00:00')
            )
        );

        $reserve2 = new Reserve(
            new ReserveInterval(
                new DateTime('2020-08-12 17:30:00'),
                new DateTime('2020-08-12 18:30:00')
            )
        );

        $this->assertTrue($reserve1->intersectWith($reserve2));
        $this->assertTrue($reserve2->intersectWith($reserve1));
    }
}