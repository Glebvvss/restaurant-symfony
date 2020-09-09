<?php

namespace App\Module\TableReservation\Action\Table;

use App\Entity\Hall;
use App\Repository\HallRepository;
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

    public function handle(int $hallId, int $number): void
    {
        $hall  = $this->hallRepository->findOne($hallId);
        $table = $hall->getTableByNumber($number);
        $hall->removeTable($table);
        $this->em->remove($table);
        $this->em->flush();
    }
}