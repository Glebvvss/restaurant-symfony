<?php

namespace App\Module\TableReservation\Action\Reserve;

use Doctrine\ORM\EntityManagerInterface;
use App\Module\TableReservation\Entity\Reserve;
use App\Module\TableReservation\Repository\ReserveRepository;

class DeleteAction
{
    private EntityManagerInterface $em;
    private ReserveRepository      $reserveRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em                = $em;
        $this->reserveRepository = $em->getRepository(Reserve::class);
    }

    public function handle(int $id): void
    {
        $reserve = $this->reserveRepository->findOne($id);
        $this->em->remove($reserve);
        $this->em->flush();
    }
}