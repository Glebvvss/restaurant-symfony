<?php

namespace App\Controller;

use DateTime;
use App\Entity\Hall;
use App\Entity\Table;
use App\Entity\Reserve;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HallController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/")
     */
    public function index()
    {
        $hallRepository = $this->em->getRepository(Hall::class);
        
        $hall = $hallRepository->find(2);

        dump($hall->getTables()[0]->getReserves());
        die;
    }
}