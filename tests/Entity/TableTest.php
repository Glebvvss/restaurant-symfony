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
    private const CLIENT_NAME = 'John Mayer';

    public function test_getNumber()
    {
        $table = new Table(1);
        $this->assertEquals(1, $table->getNumber());
    }

    public function test_reserves()
    {
        $table = new Table(1);
        $reserve = new Reserve(
            static::CLIENT_NAME,
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
            static::CLIENT_NAME,
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
            static::CLIENT_NAME,
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
}