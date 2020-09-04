<?php

namespace App\Repository;

use App\Entity\Hall;
use App\Exception\ErrorReporting;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Hall find(int $id)
 * @method Hall|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hall[]    findAll()
 * @method Hall[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HallRepository extends ServiceEntityRepository
{
    private const INCORRECT_ID_ERROR_MSG = 'Incorrect entity id';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hall::class);
    }

    public function findOne(int $id): Hall
    {
        if (!$hall = $this->find($id)) {
            throw new ErrorReporting(static::INCORRECT_ID_ERROR_MSG);
        }

        return $hall;
    }
}
