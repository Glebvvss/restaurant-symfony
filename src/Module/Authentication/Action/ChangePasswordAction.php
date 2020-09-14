<?php

namespace App\Module\Authentication\Action;

use Doctrine\ORM\EntityManagerInterface;
use App\Module\Authentication\Entity\User;
use App\Module\Authentication\Entity\Email;
use App\Module\Authentication\Entity\Username;
use App\Module\Authentication\Entity\Password;
use App\Module\Authentication\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ChangePasswordAction
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
        string $currentPassword,
        string $newPassword
    )
    {
        $user = $this->userRepository->findOneByUsername($username);
        $user->changePassword(
            new Password($currentPassword),
            new Password($newPassword),
            $this->passwordEncoder
        );
        $this->em->flush();
    }
}