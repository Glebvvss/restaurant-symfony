<?php

namespace App\Module\Authentication\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Module\Authentication\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    private const CURRENT_PASSWORD_INCORRECT_ERROR_MSG = 'Current password incorrect';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Embedded("Username")
     */
    private Username $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $password;

    /**
     * @ORM\Embedded("Email")
     */
    private Email $email;

    public function __construct(
        Username     $username,
        Email        $email,
        PasswordHash $password
    )
    {
        $this->username = $username;
        $this->email    = $email;
        $this->password = $password;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function changePassword(
        PasswordHash $currentPassword, 
        PasswordHash $newPassword 
    )
    {
        if ($this->password !== $currentPassword) {
            throw new ErrorReporting(static::CURRENT_PASSWORD_INCORRECT_ERROR_MSG);
        }

        $this->password = $newPassword;
    }

    public function passwordIncorrect(PasswordHash $password): bool
    {
        return $password !== $this->password;
    }

    public function getSalt() {}
    public function eraseCredentials() {}
}