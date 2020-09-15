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
    private const LOGIN_FAILED_ERROR_MSG = 'Login failed';

    private UserRepository               $userRepository;
    private JWTTokenManagerInterface     $jwtToken;
    private UserPasswordEncoderInterface $encoder;

    public function __construct(
        EntityManagerInterface       $em,
        JWTTokenManagerInterface     $jwtToken,
        UserPasswordEncoderInterface $encoder
    )
    {
        $this->jwtToken        = $jwtToken;
        $this->passwordEncoder = $encoder;
        $this->userRepository  = $em->getRepository(User::class);
    }

    public function handle(string $username, string $password)
    {
        $user = $this->userRepository->findOneByUsername(new Username($username));

        if ($user->passwordNoMatched(new Password($password), $this->encoder)) {
            throw new ErrorReporting(static::LOGIN_FAILED_ERROR_MSG);
        }

        return ['token' => $this->jwtToken->create($user)];
    }
}