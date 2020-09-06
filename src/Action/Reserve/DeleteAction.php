<?php

namespace App\Action\Reserve;

use App\Entity\Reserve;
use App\Repository\ReserveRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeleteAction
{
    private EntityManagerInterface $em;
    private ReserveRepository      $reserveRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em                = $em;
        $this->reserveRepository = $em->getRepository(Reserve::class);
    }

    public function handle(int $id): void
    {
        $reserve = $this->reserveRepository->findOne($id);
        $this->em->remove($reserve);
        $this->em->flush();
    }
}