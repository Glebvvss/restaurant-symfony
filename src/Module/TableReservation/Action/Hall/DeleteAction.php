<?php

namespace App\Module\TableReservation\Action\Hall;

use App\Module\TableReservation\Entity\Hall;
use App\Module\TableReservation\Repository\HallRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeleteAction
{
    private EntityManagerInterface $em;
    private HallRepository         $hallRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em             = $em;
        $this->hallRepository = $em->getRepository(Hall::class);
    }

    public function handle(int $id)
    {
        $hall = $this->hallRepository->findOne($id);
        $this->em->remove($hall);
        $this->em->flush();
    }
}