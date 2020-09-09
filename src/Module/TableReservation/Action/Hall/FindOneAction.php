<?php

namespace App\Module\TableReservation\Action\Hall;

use App\Entity\Hall;
use App\Repository\HallRepository;
use App\Presentation\HallPresentation;
use Doctrine\ORM\EntityManagerInterface;

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