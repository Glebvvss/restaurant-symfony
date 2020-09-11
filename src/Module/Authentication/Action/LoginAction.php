<?php

namespace App\Module\Authentication\Action;

use Exception;
use App\Common\Exception\ErrorReporting;
use Doctrine\ORM\EntityManagerInterface;
use App\Module\Authentication\Entity\User;
use App\Module\Authentication\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class LoginAction
{
    private const INCORRECT_PASSWORD_ERROR_MSG = 'Incorrect password';

    private const NO_SUCCESS_LOGIN_ERROR_MSG = 'No success login';

    private UserRepository               $em;
    private JWTTokenManagerInterface     $jwtToken;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(
        EntityManagerInterface       $em,
        JWTTokenManagerInterface     $jwtToken,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->jwtToken        = $jwtToken;
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository  = $em->getRepository(User::class);
    }

    public function handle(string $username, string $password)
    {
        $user = $this->userRepository->findOneByUsername($username);
        if ($user->getPassword() !== $this->passwordEncoder->encodePassword($user, $password)) {
            throw new ErrorReporting(static::INCORRECT_PASSWORD_ERROR_MSG);
        }

        return ['token' => $jwtToken->create($user)];
    }
}