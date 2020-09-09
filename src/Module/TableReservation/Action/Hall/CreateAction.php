<?php

namespace App\Module\TableReservation\Action\Hall;

use App\Module\TableReservation\Entity\Hall;
use App\Common\Exception\ErrorReporting;
use App\Module\TableReservation\Repository\HallRepository;
use App\Module\TableReservation\Presentation\HallPresentation;
use Doctrine\ORM\EntityManagerInterface;

class CreateAction
{
    private const HALL_NAME_RESERVED_ERROR_MSG = 'Hall name already reserved';

    private EntityManagerInterface $em;
    private HallRepository         $hallRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em             = $em;
        $this->hallRepository = $em->getRepository(Hall::class);
    }

    public function handle(string $name)
    {
        if ($this->hallRepository->nameReserved($name)) {
            throw new ErrorReporting(static::HALL_NAME_RESERVED_ERROR_MSG);
        }

        $hall = new Hall($name);
        $this->em->persist($hall);
        $this->em->flush();
        return (new HallPresentation($hall))->toArray();
    }
}