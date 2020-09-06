<?php

namespace App\Repository;

use App\Entity\Hall;
use Doctrine\Persistence\ManagerRegistry;

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
