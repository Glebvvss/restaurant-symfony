<?php

namespace App\Module\Authentication\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Module\Authentication\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface as EncoderInterface;

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
        Username         $username,
        Email            $email,
        Password         $password,
        EncoderInterface $encoder
    )
    {
        $this->username = $username;
        $this->email    = $email;
        $this->password = $encoder->encodePassword($this, $password);
    }

    public function getUsername()
    {
        return (string) $this->username;
    }

    public function getPassword()
    {
        return (string) $this->password;
    }

    public function getEmail()
    {
        return (string) $this->email;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function changePassword(
        Password         $currentPassword, 
        Password         $newPassword, 
        EncoderInterface $encoder
    )
    {
        if ($this->password !== $encoder->encodePassword($this, $currentPassword)) {
            throw new ErrorReporting(static::CURRENT_PASSWORD_INCORRECT_ERROR_MSG);
        }

        $this->password = $encoder->encodePassword($this, $newPassword);
    }

    public function passwordNoMatched(Password $password, EncoderInterface $encoder)
    {
        return $encoder->encodePassword($this, $password) !== (string) $this->password;
    }

    public function getSalt() {}
    public function eraseCredentials() {}
}