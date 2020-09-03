<?php

namespace App\Presentation;

use App\Entity\Reserve;

class ReservePresentation implements PresentationInterface
{
    private const TIME_FORMAT = 'Y-m-d H:i';

    private Reserve $reserve;

    public function __construct(Reserve $reserve)
    {
        $this->reserve = $reserve;
    }

    public function toArray(): array
    {
        return [
            'id'        => $this->reserve->getId(),
            'time_from' => $this->reserve->getTimeFrom()->format(static::TIME_FORMAT),
            'time_to'   => $this->reserve->getTimeTo()->format(static::TIME_FORMAT),
        ];
    }
}