<?php

namespace App\Module\Authentication\Action;

use App\Common\Exception\ErrorReporting;
use Doctrine\ORM\EntityManagerInterface;
use App\Module\Authentication\Entity\User;
use App\Module\Authentication\Entity\Password;
use App\Module\Authentication\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class LoginAction
{
    private UserRepository               $userRepository;
    private JWTTokenManagerInterface     $tokenFactory;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(
        EntityManagerInterface       $em,
        JWTTokenManagerInterface     $tokenFactory,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->tokenFactory    = $tokenFactory;
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository  = $em->getRepository(User::class);
    }

    public function handle(string $username, string $password)
    {
        $user  = $this->userRepository->findOneByUsername(new Username($username));
        $token = $user->login(
            new Username($username), 
            new PasswordHash(
                new Password($password),
                $this->passwordEncoder
            ),
            $this->tokenFactory
        );
        return ['token' => $token];
    }
}