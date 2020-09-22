<?php

namespace App\Test\Stub;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class TokenFactoryStub implements JWTTokenManagerInterface
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @param UserInterface $user
     *
     * @return string The JWT token
     */
    public function create(UserInterface $user)
    {
        return $this->token;
    }

    public function decode(TokenInterface $token)
    {
    }

    public function setUserIdentityField($field)
    {
    }

    public function getUserIdentityField()
    {
    }

    public function getUserIdClaim()
    {
    }
}
