<?php

namespace App\Presentation;

use App\Entity\Hall;

class HallPresentation implements PresentationInterface
{
    private Hall $hall;

    public function __construct(Hall $hall)
    {
        $this->hall = $hall;
    }

    public function toArray(): array
    {
        return [
            'id'   => $this->hall->getId(),
            'name' => $this->hall->getName(),
        ];
    }
}