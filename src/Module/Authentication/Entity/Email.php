<?php

namespace App\Module\Authentication\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Common\Exception\ErrorReporting;

/**
 * @ORM\Embeddable
 */
class Email
{
    private const IS_NOT_EMAIL_ERROR_MSG = 'Is not email';

    /**
     * @ORM\Column(type="string", length=45, unique=true)
     */
    private string $email;

    public function __construct(string $email)
    {
        $email = trim($email);

        if (empty($email) || mb_strpos('@') < 1) {
            throw new ErrorReporting(static::IS_NOT_EMAIL_ERROR_MSG);
        }

        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}