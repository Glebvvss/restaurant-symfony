<?php

namespace App\Module\Authentication\Action;

use Throwble;
use App\Common\Exception\ErrorReporting;
use Doctrine\ORM\EntityManagerInterface;
use App\Module\Authentication\Entity\User;
use App\Module\Authentication\Entity\Username;
use App\Module\Authentication\Entity\Password;
use App\Module\Authentication\Entity\PasswordHash;
use App\Module\Authentication\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class LoginAction
{
    private const PASSWORD_INCORRECT_ERROR_MSG = 'Password incorrect';
    private const LOGIN_FAILED_ERROR_MSG = 'Login failed';

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
        try {
            $user = $this->userRepository->findOneByUsername(new Username($username));

            if ($this->passwordEncoder->isPasswordValid($user, (string) new Password($password))) {
                return ['token' => $this->tokenFactory->create($user)];    
            }

            throw new ErrorReporting(static::PASSWORD_INCORRECT_ERROR_MSG);
        } catch (Throwble $ex) {
            throw new ErrorReporting(static::LOGIN_FAILED_ERROR_MSG);    
        } 
    }
}