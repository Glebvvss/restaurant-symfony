<?php

namespace App\Action\Reserve;

use App\Entity\Reserve;
use App\Repository\ReserveRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Presentation\ReserveAdvancedPresentation;

class FindOneAction
{
    private ReserveRepository $reserveRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->reserveRepository = $em->getRepository(Reserve::class);
    }

    public function handle(int $id): array
    {
        $reserve = $this->reserveRepository->findOne($id);
        return (new ReserveAdvancedPresentation($reserve))->toArray();
    }
}