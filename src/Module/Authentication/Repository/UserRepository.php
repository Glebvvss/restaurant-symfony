<?php

namespace App\Module\Authentication\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Module\Authentication\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneByUserNameAndPasswordHash(string $username, string $passwordHash)
    {
        if ($rows = $this->findBy(['username' => $username, 'password' => $passwordHash])) {
            return reset($rows);
        }

        throw new ErrorReporting('User not exists');
    }
}
