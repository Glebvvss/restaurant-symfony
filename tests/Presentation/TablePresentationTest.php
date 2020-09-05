<?php

namespace App\Test\Presentation;

use App\Entity\Table;
use PHPUnit\Framework\TestCase;
use App\Presentation\TablePresentation;

class TablePresentationTest extends TestCase
{
    public function test_toArray()
    {
        $tableNumber = 1;
        $table = new Table($tableNumber);
        $presentation = new TablePresentation($table);

        $this->assertEquals(
            [
                'number' => $tableNumber
            ],
            $presentation->toArray()
        );
    }
}