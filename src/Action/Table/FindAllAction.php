<?php

namespace App\Action\Table;

use App\Entity\Hall;
use App\Repository\HallRepository;
use App\Presentation\TablePresentation;
use Doctrine\ORM\EntityManagerInterface;

class FindAllAction
{
    private HallRepository $hallRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->hallRepository = $em->getRepository(Hall::class);
    }

    public function handle(int $hallId): array
    {
        $hall = $this->hallRepository->findOne($hallId);
        return array_map(
            fn($table) => (new TablePresentation($table))->toArray(),
            $hall->getTables()->toArray()
        );
    }
}