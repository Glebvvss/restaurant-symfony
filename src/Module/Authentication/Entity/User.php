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
        $this->setPassword($password, $encoder);
    }

    public function getUsername()
    {
        return (string) $this->username;
    }

    public function getPassword()
    {
        return (string) $this->password;
    }

    public function setPassword(Password $password, EncoderInterface $encoder)
    {
        $this->password = $encoder->encodePassword($this, $password);
    }

    public function passwordNoMatched(Password $password, EncoderInterface $encoder)
    {
        return $encoder->encodePassword($this, $password) !== (string) $this->password;
    }

    public function getEmail()
    {
        return (string) $this->email;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function getSalt() {}
    public function eraseCredentials() {}
}