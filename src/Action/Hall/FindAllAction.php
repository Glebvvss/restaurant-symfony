<?php

namespace App\Action\Hall;

use App\Entity\Hall;
use App\Repository\HallRepository;
use App\Presentation\HallPresentation;
use Doctrine\ORM\EntityManagerInterface;

class FindAllAction
{
    private HallRepository $hallRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->hallRepository = $em->getRepository(Hall::class);
    }

    public function handle()
    {
        $hallList = $this->hallRepository->findAll();
        return array_map(
            fn($hall) => ( new HallPresentation($hall) )->toArray(),
            $hallList
        );
    }
}