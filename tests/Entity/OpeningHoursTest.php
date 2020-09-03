<?php 

namespace App\Test\Entity;

use DateTime;
use App\Entity\OpeningHours;
use PHPUnit\Framework\TestCase;

class OpeningHoursTest extends TestCase
{
    public function test_isOpenedAt_isClosedAt_openTime()
    {
        $openingHours = new OpeningHours();
        $time = new DateTime('16:00');

        $this->assertTrue($openingHours->isOpenedAt($time));
        $this->assertFalse($openingHours->isClosedAt($time));
    }

    public function test_isOpenedAt_isClosedAt_closeTime()
    {
        $openingHours = new OpeningHours();
        $time = new DateTime('04:00');

        $this->assertFalse($openingHours->isOpenedAt($time));
        $this->assertTrue($openingHours->isClosedAt($time));
    }
}
