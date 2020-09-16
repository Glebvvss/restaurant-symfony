<?php

namespace App\Module\TableReservation\Action\Hall;

use App\Common\Exception\ErrorReporting;
use Doctrine\ORM\EntityManagerInterface;
use App\Module\TableReservation\Entity\Hall;
use App\Module\TableReservation\Repository\HallRepository;
use App\Module\TableReservation\Presentation\HallPresentation;

class CreateAction
{
    private EntityManagerInterface $em;
    private HallRepository         $hallRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em             = $em;
        $this->hallRepository = $em->getRepository(Hall::class);
    }

    public function handle(string $name)
    {
        $hall = new Hall($name);
        $this->hallRepository->persist($hall);
        $this->em->flush();
        return (new HallPresentation($hall))->toArray();
    }
}