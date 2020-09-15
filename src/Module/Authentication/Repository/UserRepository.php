<?php

namespace App\Module\Authentication\Repository;

use App\Common\Exception\ErrorReporting;
use Doctrine\Persistence\ManagerRegistry;
use App\Module\Authentication\Entity\User;
use App\Module\Authentication\Entity\Username;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class UserRepository extends ServiceEntityRepository
{
    private const USER_NOT_FOUND_ERROR_MSG = 'User not found';

    private const USERNAME_IN_USE_ERROR_MSG = 'Username already in use';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneByUsername(Username $username): User
    {
        $user = $this->createQueryBuilder('u')
                     ->andWhere('u.username.username = :username')
                     ->setParameter(':username', $username)
                     ->getQuery()
                     ->getOneOrNullResult();

        if ($user) {
            return $user;
        }

        throw new ErrorReporting(static::USER_NOT_FOUND_ERROR_MSG);
    }

    public function usernameReserved(Username $username): bool
    {
        $user = $this->createQueryBuilder('u')
                     ->andWhere('u.username.username = :username')
                     ->setParameter(':username', $username)
                     ->getQuery()
                     ->getOneOrNullResult();

        return !is_null($user);
    }

    public function persist(User $user)
    {
        if ($this->usernameReserved($user->getUsername())) {
            throw new ErrorReporting(static::USERNAME_IN_USE_ERROR_MSG);
        }

        $this->getEntityManager()->persist($user);
    }
}
