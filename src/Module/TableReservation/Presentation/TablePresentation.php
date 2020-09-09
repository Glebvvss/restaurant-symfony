<?php

namespace App\Module\TableReservation\Presentation;

use App\Module\TableReservation\Entity\Table;

class TablePresentation implements PresentationInterface
{
    private Table $table;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function toArray(): array
    {
        return [
            'number' => $this->table->getNumber(),
        ];
    }
}