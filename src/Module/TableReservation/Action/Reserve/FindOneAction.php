<?php

namespace App\Module\TableReservation\Action\Reserve;

use App\Module\TableReservation\Entity\Reserve;
use App\Module\TableReservation\Repository\ReserveRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Module\TableReservation\Presentation\ReserveAdvancedPresentation;

class FindOneAction
{
    private ReserveRepository $reserveRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->reserveRepository = $em->getRepository(Reserve::class);
    }

    public function handle(int $id): array
    {
        $reserve = $this->reserveRepository->findOne($id);
        return (new ReserveAdvancedPresentation($reserve))->toArray();
    }
}