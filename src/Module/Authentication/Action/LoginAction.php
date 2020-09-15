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
    private UserPasswordEncoderInterface $encoder;

    public function __construct(
        EntityManagerInterface       $em,
        JWTTokenManagerInterface     $tokenFactory,
        UserPasswordEncoderInterface $encoder
    )
    {
        $this->tokenFactory    = $tokenFactory;
        $this->passwordEncoder = $encoder;
        $this->userRepository  = $em->getRepository(User::class);
    }

    public function handle(string $username, string $password)
    {
        $user  = $this->userRepository->findOneByUsername(new Username($username));
        $token = $user->login(
            new Username($username), 
            new Password($password),
            $this->encoder,
            $this->tokenFactory
        );
        return ['token' => $token];
    }
}