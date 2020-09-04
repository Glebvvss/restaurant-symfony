<?php

namespace App\Action\Hall;

use App\Entity\Hall;
use App\Presentation\HallPresentation;
use Doctrine\ORM\EntityManagerInterface;

class FindOneAction
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function handle(int $id)
    {
        $hall = new HallPresentation(
            $this->em
                 ->getRepository(Hall::class)
                 ->findOne($id)
        );

        return $hall->toArray();
    }
}