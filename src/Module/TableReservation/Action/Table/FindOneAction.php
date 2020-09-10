<?php

namespace App\Module\TableReservation\Action\Table;

use Doctrine\ORM\EntityManagerInterface;
use App\Module\TableReservation\Entity\Hall;
use App\Module\TableReservation\Repository\HallRepository;
use App\Module\TableReservation\Presentation\TablePresentation;

class FindOneAction
{
    private HallRepository $hallRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->hallRepository = $em->getRepository(Hall::class);
    }

    public function handle(int $hallId, int $number): array
    {
        $hall  = $this->hallRepository->findOne($hallId);
        $table = $hall->getTableByNumber($number);
        return (new TablePresentation($table))->toArray();
    }
}