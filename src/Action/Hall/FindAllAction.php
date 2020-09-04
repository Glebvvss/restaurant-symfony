<?php

namespace App\Action\Hall;

use App\Entity\Hall;
use App\Presentation\HallPresentation;
use Doctrine\ORM\EntityManagerInterface;

class FindAllAction
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function handle()
    {
        $hallList = $this->em
                         ->getRepository(Hall::class)
                         ->findAll();

        return array_map(
            fn($hall) => ( new HallPresentation($hall) )->toArray(),
            $hallList
        );
    }
}