<?php

namespace App\Test\Presentation;

use DateTime;
use ReflectionClass;
use App\Entity\Hall;
use App\Entity\Table;
use App\Entity\Reserve;
use App\Entity\ReserveInterval;
use PHPUnit\Framework\TestCase;
use App\Presentation\ReserveAdvancedPresentation;

class ReserveAdvancedPresentationTest extends TestCase
{
    private const HALL_ID      = 1;
    private const TABLE_NUMBER = 1;
    private const CLIENT_NAME  = 'John Mayer';
    private const TIME_FROM    = '2020-12-12 16:00';
    private const TIME_TO      = '2020-12-12 18:00';

    public function test_toArray()
    {
        $hall  = new Hall('Main');
        $class = new ReflectionClass(Hall::class);
        $property = $class->getProperty("id");
        $property->setAccessible(true);
        $property->setValue($hall, static::HALL_ID);

        $table = new Table(1);
        $reserve = new Reserve(
            static::CLIENT_NAME,
            new ReserveInterval(
                new DateTime(static::TIME_FROM),
                new DateTime(static::TIME_TO)
            )
        );
        $table->addReserve($reserve);
        $hall->addTable($table);

        $presentation = new ReserveAdvancedPresentation($reserve);
        $this->assertEquals(
            [
                'id'           => null,
                'hall_id'      => static::HALL_ID,
                'table_number' => static::TABLE_NUMBER,
                'client_name'  => static::CLIENT_NAME,
                'time_from'    => static::TIME_FROM,
                'time_to'      => static::TIME_TO,
            ],
            $presentation->toArray()
        );
    }
}