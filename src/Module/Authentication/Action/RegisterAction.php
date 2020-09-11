<?php

namespace App\Module\Authentication\Action;

use Doctrine\ORM\EntityManagerInterface;
use App\Module\Authentication\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterAction
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private EntityManagerInterface       $em;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface       $em
    )
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->em              = $em;
    }

    public function handle(
        string $username,
        string $password,
        string $email
    )
    {
        $user = new User($username);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
        $user->setEmail($email);
        $this->em->persist($user);
        $this->em->flush();
    }
}