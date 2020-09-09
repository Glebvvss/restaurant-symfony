<?php

namespace App\Module\TableReservation\Action\Table;

use App\Module\TableReservation\Entity\Hall;
use App\Module\TableReservation\Repository\HallRepository;
use App\Module\TableReservation\Presentation\TablePresentation;
use Doctrine\ORM\EntityManagerInterface;

class FindAllAction
{
    private HallRepository $hallRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->hallRepository = $em->getRepository(Hall::class);
    }

    public function handle(int $hallId): array
    {
        $hall = $this->hallRepository->findOne($hallId);
        return array_map(
            fn($table) => (new TablePresentation($table))->toArray(),
            $hall->getTables()->toArray()
        );
    }
}