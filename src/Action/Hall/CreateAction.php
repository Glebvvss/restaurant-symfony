<?php

namespace App\Action\Hall;

use App\Entity\Hall;
use App\Presentation\HallPresentation;
use Doctrine\ORM\EntityManagerInterface;

class CreateAction
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function handle(string $name)
    {
        $hall = new Hall($name);
        $this->em->persist($hall);
        $this->em->flush();
        return ( new HallPresentation($hall) )->toArray();
    }
}