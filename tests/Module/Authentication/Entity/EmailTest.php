<?php

namespace App\Test\Module\Authentication\Entity;

use PHPUnit\Framework\TestCase;
use App\Common\Exception\ErrorReporting;
use App\Module\Authentication\Entity\Email;

class EmailTest extends TestCase
{
    const NOT_EMAIL         = 'not_email';
    const EMAIL_WITHOUT_DOT = 'john@mayerru';
    const CORRECT_EMAIL     = 'john@mayer.ru';

    public function test_toString()
    {
        $this->assertSame(
            (string) new Email(self::CORRECT_EMAIL),
            self::CORRECT_EMAIL
        );
    }

    public function test_exceptionOnEmptyEmailString()
    {
        $this->expectException(ErrorReporting::class);
        new Email('');
    }

    public function test_exceptionOnNotEmailString()
    {
        $this->expectException(ErrorReporting::class);
        new Email(self::NOT_EMAIL);
    }

    public function test_exceptionOnEmailWithoutDotString()
    {
        $this->expectException(ErrorReporting::class);
        new Email(self::EMAIL_WITHOUT_DOT);
    }
}