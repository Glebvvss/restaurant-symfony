<?php

namespace App\Module\TableReservation\Action\Hall;

use Doctrine\ORM\EntityManagerInterface;
use App\Module\TableReservation\Entity\Hall;
use App\Module\TableReservation\Repository\HallRepository;
use App\Module\TableReservation\Presentation\HallPresentation;

class FindOneAction
{
    private HallRepository $hallRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->hallRepository = $em->getRepository(Hall::class);
    }

    public function handle(int $id)
    {
        $hall = new HallPresentation(
            $this->hallRepository->findOne($id)
        );

        return $hall->toArray();
    }
}