<?php

namespace App\Module\Authentication\Security;

use App\Common\Exception\ErrorReporting;
use Doctrine\ORM\EntityManagerInterface;
use App\Module\Authentication\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Module\Authentication\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserProvider implements UserProviderInterface
{
    private UserRepository $userRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->userRepository = $em->getRepository(User::class);
    }

    public function loadUserByUsername(string $username)
    {
        try {
            return $this->userRepository->findOneByUsername($username);
        } catch (ErrorReporting $ex) {
            throw new UsernameNotFoundException();
        }
    }

    public function refreshUser(UserInterface $user)
    {
    }

    public function supportsClass($class)
    {
        return get_class($class) === User::class;
    }
}