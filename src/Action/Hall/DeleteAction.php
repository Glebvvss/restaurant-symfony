<?php

namespace App\Action\Hall;

use App\Entity\Hall;
use Doctrine\ORM\EntityManagerInterface;

class DeleteAction
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function handle(int $id)
    {
        $hall = $this->em
                     ->getRepository(Hall::class)
                     ->findOne($id);

        $this->em->remove($hall);
        $this->em->flush();
    }
}