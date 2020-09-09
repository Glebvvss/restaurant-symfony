<?php

namespace App\Repository;

use App\Common\Exception\ErrorReporting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class BaseRepository extends ServiceEntityRepository
{
    private const INCORRECT_ID_ERROR_MSG = 'Incorrect entity id';

    public function findOne(int $id): object
    {
        if (!$entity = $this->find($id)) {
            throw new ErrorReporting(self::INCORRECT_ID_ERROR_MSG);
        }

        return $entity;
    }
}
