<?php

namespace App\Module\TableReservation\Action\Hall;

use Doctrine\ORM\EntityManagerInterface;
use App\Module\TableReservation\Entity\Hall;
use App\Module\TableReservation\Repository\HallRepository;

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