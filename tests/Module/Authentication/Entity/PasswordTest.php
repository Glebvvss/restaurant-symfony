<?php

namespace App\Test\Module\Authentication\Entity;

use PHPUnit\Framework\TestCase;
use App\Common\Exception\ErrorReporting;
use App\Module\Authentication\Entity\Password;

class PasswordTest extends TestCase
{
    private const INCORRECT_PASSWORD = 'pass';
    private const CORRECT_PASSWORD   = 'password';

    public function test_toString()
    {
        $this->assertSame(
            (string) new Password(self::CORRECT_PASSWORD), 
            self::CORRECT_PASSWORD
        );
    }

    public function test_exceptionOnSmallPasswordString()
    {
        $this->expectException(ErrorReporting::class);
        new Password(self::INCORRECT_PASSWORD);
    }
}