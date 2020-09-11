<?php

namespace App\Module\Authentication\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Module\Authentication\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class UserRepository extends ServiceEntityRepository
{
    private const USER_NOT_FOUND_ERROR_MSG = 'User not found';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneByUsername(string $username)
    {
        if ($rows = $this->findBy(['username' => $username])) {
            return reset($rows);
        }

        throw new ErrorReporting(static::USER_NOT_FOUND_ERROR_MSG);
    }
}
