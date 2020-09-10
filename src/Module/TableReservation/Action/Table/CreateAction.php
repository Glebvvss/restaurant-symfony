<?php

namespace App\Module\TableReservation\Action\Table;

use Doctrine\ORM\EntityManagerInterface;
use App\Module\TableReservation\Entity\Hall;
use App\Module\TableReservation\Entity\Table;
use App\Module\TableReservation\Repository\HallRepository;
use App\Module\TableReservation\Presentation\TablePresentation;

class CreateAction
{
    private EntityManagerInterface $em;
    private HallRepository         $hallRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em             = $em;
        $this->hallRepository = $em->getRepository(Hall::class);
    }

    public function handle(int $hallId, int $number)
    {
        $hall  = $this->hallRepository->findOne($hallId);
        $table = new Table($number);
        $hall->addTable($table);
        $this->em->flush();
        return (new TablePresentation($table))->toArray();
    }
}