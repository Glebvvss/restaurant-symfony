<?php

namespace App\Module\TableReservation\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Module\TableReservation\Entity\Reserve;

class ReserveRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reserve::class);
    }
}
