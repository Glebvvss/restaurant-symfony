<?php

namespace App\Module\TableReservation\Action\Reserve;

use App\Module\TableReservation\Entity\Hall;
use App\Module\TableReservation\Repository\HallRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Module\TableReservation\Presentation\ReservePresentation;

class FindActualByTableAction
{
    private HallRepository $hallRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->hallRepository = $em->getRepository(Hall::class);
    }

    public function handle(int $hallId, int $tableNumber)
    {
        $hall     = $this->hallRepository->findOne($hallId);
        $table    = $hall->getTableByNumber($tableNumber);
        $reserves = $table->getReserves();
        return array_map(
            fn($reserve) => (new ReservePresentation($reserve))->toArray(),
            $reserves->toArray()
        );
    }
}