<?php

namespace App\Test\Module\Authentication\Entity;

use PHPUnit\Framework\TestCase;
use App\Common\Exception\ErrorReporting;
use App\Module\Authentication\Entity\Username;

class UsernameTest extends TestCase
{
    const USERNAME = 'John';

    public function test_toString()
    {
        $username = new Username(self::USERNAME);
        $this->assertSame((string) $username, self::USERNAME);
    }

    public function test_exceptionOnEmptyUsernameString()
    {
        $this->expectException(ErrorReporting::class);
        new Username('');
    }

    public function test_exceptionOnSoSmallUsernameString()
    {
        $this->expectException(ErrorReporting::class);
        new Username('n');
    }
}