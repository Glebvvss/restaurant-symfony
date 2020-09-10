<?php

namespace App\Module\TableReservation\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Module\TableReservation\Entity\Hall;

class HallRepository extends BaseRepository
{
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
}
