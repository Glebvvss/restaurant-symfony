<?php

namespace App\Module\Authentication\Entity;

use App\Common\Exception\ErrorReporting;

class Password
{
    private const PASSWORD_FORMAT_ERROR_MSG = 'Password must be longer than 6 symbols';

    private string $password;

    public function __construct(string $password)
    {
        if (mb_strlen($password) < 6) {
            throw new ErrorReporting(static::PASSWORD_FORMAT_ERROR_MSG);
        }

        $this->password = $password;
    }

    public function __toString(): string
    {
        return $this->password;
    }
}