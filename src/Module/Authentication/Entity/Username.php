<?php

namespace App\Module\Authentication\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Username
{
    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private string $username;

    public function __construct(string $username)
    {
        $this->username = $username;
    }

    public function __toString(): string
    {
        return $this->username;
    }
}