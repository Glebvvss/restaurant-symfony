<?php

namespace App\Presentation;

use App\Entity\Hall;
use App\Entity\Table;
use App\Entity\Reserve;

class ReserveAdvancedPresentation implements PresentationInterface
{
    private const TIME_FORMAT = 'Y-m-d H:i';

    private Hall    $hall;
    private Table   $table;
    private Reserve $reserve;

    public function __construct(Reserve $reserve)
    {
        $this->reserve = $reserve;
        $this->table   = $reserve->getTable();
        $this->hall    = $this->table->getHall();
    }

    public function toArray(): array
    {
        return [
            'id'           => $this->reserve->getId(),
            'hall_id'      => $this->hall->getId(),
            'table_number' => $this->table->getNumber(),
            'client_name'  => $this->reserve->getClientName(),
            'time_from'    => $this->reserve->getTimeFrom()->format(static::TIME_FORMAT),
            'time_to'      => $this->reserve->getTimeTo()->format(static::TIME_FORMAT),
        ];
    }
}