<?php

namespace App\Module\Authentication\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Email
{
    /**
     * @ORM\Column(type="string", length=45, unique=true)
     */
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}