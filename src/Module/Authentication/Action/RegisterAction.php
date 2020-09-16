<?php

namespace App\Module\Authentication\Action;

use Doctrine\ORM\EntityManagerInterface;
use App\Module\Authentication\Entity\User;
use App\Module\Authentication\Entity\Email;
use App\Module\Authentication\Entity\Username;
use App\Module\Authentication\Entity\Password;
use App\Module\Authentication\Entity\PasswordHash;
use App\Module\Authentication\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterAction
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private UserRepository               $userRepository;
    private EntityManagerInterface       $em;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface       $em
    )
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository  = $em->getRepository(User::class);
        $this->em              = $em;
    }

    public function handle(
        string $username,
        string $password,
        string $email
    )
    {
        $user = new User(
            new Username($username),
            new Email($email),
            new PasswordHash(
                new Password($password),
                $this->passwordEncoder
            )
        );

        $this->userRepository->persist($user);
        $this->em->flush();
    }
}