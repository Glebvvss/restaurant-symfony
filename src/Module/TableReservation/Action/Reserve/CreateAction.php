<?php

namespace App\Module\TableReservation\Action\Reserve;

use DateTime;
use App\Entity\Hall;
use App\Entity\Reserve;
use App\Entity\ReserveInterval;
use App\Repository\HallRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Presentation\ReservePresentation;

class CreateAction
{
    private EntityManagerInterface $em;
    private HallRepository         $hallRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em             = $em;
        $this->hallRepository = $em->getRepository(Hall::class);
    }

    public function handle(
        int      $hallId, 
        int      $tableNumber,
        string   $clientName,
        DateTime $timeFrom,
        DateTime $timeTo
    )
    {
        $hall    = $this->hallRepository->findOne($hallId);
        $table   = $hall->getTableByNumber($tableNumber);
        $reserve = new Reserve(
            $clientName,
            new ReserveInterval($timeFrom, $timeTo)
        );
        $table->addReserve($reserve);
        $this->em->flush();
        return (new ReservePresentation($reserve))->toArray();
    }
}