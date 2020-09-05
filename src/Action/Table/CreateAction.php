<?php

namespace App\Action\Table;

use App\Entity\Hall;
use App\Entity\Table;
use App\Repository\HallRepository;
use App\Presentation\TablePresentation;
use Doctrine\ORM\EntityManagerInterface;

class CreateAction
{
    private EntityManagerInterface $em;
    private HallRepository         $hallRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em             = $em;
        $this->hallRepository = $em->getRepository(Hall::class);
    }

    public function handle(int $hallId, int $number)
    {
        $hall  = $this->hallRepository->findOne($hallId);
        $table = new Table($number);
        $hall->addTable($table);
        $this->em->flush();
        return (new TablePresentation($table))->toArray();
    }
}