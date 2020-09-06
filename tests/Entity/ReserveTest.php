<?php

namespace App\Test\Entity;

use DateTime;
use App\Entity\Table;
use App\Entity\Reserve;
use BadMethodCallException;
use App\Entity\ReserveInterval;
use PHPUnit\Framework\TestCase;
use App\Exception\ErrorReporting;

class ReserveTest extends TestCase
{
    private const CLIENT_NAME = 'John Mayer';

    public function test_createWhenTimeFromGtTimeTo()
    {
        $this->expectException(ErrorReporting::class);

        new Reserve(
            self::CLIENT_NAME,
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
            self::CLIENT_NAME,
            new ReserveInterval(
                new DateTime('2020-08-12 18:00:00'),
                new DateTime('2020-08-12 18:00:00')
            )
        );
    }

    public function test_getClientName()
    {
        $reserve = new Reserve(
            self::CLIENT_NAME,
            new ReserveInterval(
                new DateTime('2020-08-12 18:00:00'),
                new DateTime('2020-08-12 19:00:00')
            )
        );

        $this->assertSame(self::CLIENT_NAME, $reserve->getClientName());
    }

    public function test_getTimeFrom_getTimeTo()
    {
        $timeFrom = new DateTime('2020-08-12 18:00:00');
        $timeTo   = new DateTime('2020-08-12 20:00:00');
        $reserve  = new Reserve(
            self::CLIENT_NAME,
            new ReserveInterval($timeFrom, $timeTo)
        );

        $this->assertSame($timeFrom, $reserve->getTimeFrom());
        $this->assertSame($timeTo,   $reserve->getTimeTo());
    }

    public function test_intersectWith_noIntersect()
    {
        $reserve1 = new Reserve(
            self::CLIENT_NAME,
            new ReserveInterval(
                new DateTime('2020-08-12 18:00:00'),
                new DateTime('2020-08-12 20:00:00')
            )
        );

        $reserve2 = new Reserve(
            self::CLIENT_NAME,
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
        $reserve1 = new Reserve(
            self::CLIENT_NAME,
            new ReserveInterval(
                new DateTime('2020-08-12 18:00:00'),
                new DateTime('2020-08-12 20:00:00')
            )
        );

        $reserve2 = new Reserve(
            self::CLIENT_NAME,
            new ReserveInterval(
                new DateTime('2020-08-12 17:30:00'),
                new DateTime('2020-08-12 18:30:00')
            )
        );

        $this->assertTrue($reserve1->intersectWith($reserve2));
        $this->assertTrue($reserve2->intersectWith($reserve1));
    }

    public function test_setTable_getTable()
    {
        $reserve = new Reserve(
            self::CLIENT_NAME,
            new ReserveInterval(
                new DateTime('2020-08-12 17:30:00'),
                new DateTime('2020-08-12 18:30:00')
            )
        );

        $table  = new Table(1);
        $reserve->setTable($table);
        $this->assertSame($table, $reserve->getTable());
    }

    public function test_setTable_doubbleSet()
    {
        $this->expectException(BadMethodCallException::class);

        $reserve = new Reserve(
            self::CLIENT_NAME,
            new ReserveInterval(
                new DateTime('2020-08-12 17:30:00'),
                new DateTime('2020-08-12 18:30:00')
            )
        );

        $table  = new Table(1);
        $reserve->setTable($table);
        $reserve->setTable($table);
    }
}