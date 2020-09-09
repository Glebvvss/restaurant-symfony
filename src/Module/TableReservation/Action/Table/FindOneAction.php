<?php

namespace App\Module\TableReservation\Action\Table;

use App\Entity\Hall;
use App\Repository\HallRepository;
use App\Presentation\TablePresentation;
use Doctrine\ORM\EntityManagerInterface;

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