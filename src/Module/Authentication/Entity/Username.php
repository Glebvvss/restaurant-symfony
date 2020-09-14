<?php

namespace App\Module\Authentication\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Common\Exception\ErrorReporting;

/**
 * @ORM\Embeddable
 */
class Username
{
    private const USERNAME_FORMAT_ERROR_MSG = 'Username must not be emtry string and has length less than 1 symbol';

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private string $username;

    public function __construct(string $username)
    {
        $username = trim($username);

        if (mb_strlen($username) < 1) {
            throw new ErrorReporting(static::USERNAME_FORMAT_ERROR_MSG);
        }

        $this->username = $username;
    }

    public function __toString(): string
    {
        return $this->username;
    }
}