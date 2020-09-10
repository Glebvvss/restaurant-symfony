<?php

namespace App\Module\TableReservation\Action\Hall;

use Doctrine\ORM\EntityManagerInterface;
use App\Module\TableReservation\Entity\Hall;
use App\Module\TableReservation\Repository\HallRepository;
use App\Module\TableReservation\Presentation\HallPresentation;

class FindAllAction
{
    private HallRepository $hallRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->hallRepository = $em->getRepository(Hall::class);
    }

    public function handle()
    {
        $hallList = $this->hallRepository->findAll();
        return array_map(
            fn($hall) => ( new HallPresentation($hall) )->toArray(),
            $hallList
        );
    }
}