<?php

namespace App\Module\TableReservation\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Module\TableReservation\Entity\Hall;

class HallRepository extends BaseRepository
{
    private const HALL_NAME_RESERVED_ERROR_MSG = 'Hall name already reserved';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hall::class);
    }

    public function nameReserved(string $name): bool
    {
        return (bool) $this->findBy([
            'name' => $name
        ]);
    }

    public function persist(Hall $hall)
    {
        if ($this->nameReserved($hall->getName())) {
            throw new ErrorReporting(static::HALL_NAME_RESERVED_ERROR_MSG);
        }

        $this->getEntityManager()->persist($hall);
    }
}
