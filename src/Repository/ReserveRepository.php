<?php

namespace App\Repository;

use App\Entity\Reserve;
use Doctrine\Persistence\ManagerRegistry;

class ReserveRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reserve::class);
    }
}
