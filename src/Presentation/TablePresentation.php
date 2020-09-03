<?php

namespace App\Presentation;

use App\Entity\Table;

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
            'id'     => $this->table->getId(),
            'number' => $this->table->getNumber(),
        ];
    }
}