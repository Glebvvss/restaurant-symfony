<?php

namespace App\Test\Entity;

use DateTime;
use App\Entity\Hall;
use App\Entity\Table;
use App\Entity\Reserve;
use App\Entity\ReserveInterval;
use PHPUnit\Framework\TestCase;
use App\Exception\ErrorReporting;

class TableTest extends TestCase
{
    public function test_getNumber()
    {
        $hall = new Hall('Main');
        $table = new Table($hall, 1);
        $this->assertEquals(1, $table->getNumber());
    }

    public function test_reserves()
    {
        $hall = new Hall('Main');
        $table = new Table($hall, 1);
        $reserve = new Reserve(
            $table, 
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

        $hall = new Hall('Main');
        $table = new Table($hall, 1);
        $reserve = new Reserve(
            $table, 
            new ReserveInterval(
                new DateTime('2020-08-12 18:00:00'),
                new DateTime('2020-08-12 20:00:00')
            )
        );

        $table->removeReserve($reserve);
    }

    public function test_removeExistingReserve()
    {
        $hall = new Hall('Main');
        $table = new Table($hall, 1);
        $reserve = new Reserve(
            $table, 
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