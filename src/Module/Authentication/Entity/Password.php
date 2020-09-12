<?php

namespace App\Module\Authentication\Entity;

class Password
{
    private string $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function __toString(): string
    {
        return $this->password;
    }
}