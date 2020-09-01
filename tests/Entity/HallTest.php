<?php 

namespace App\Test\Entity;

use App\Entity\Hall;
use App\Entity\Table;
use PHPUnit\Framework\TestCase;
use App\Exception\ErrorReporting;

class HallTest extends TestCase
{
    public function test_create_withValidName()
    {
        $hallName = 'Main';
        $hall = new Hall($hallName);
        $this->assertSame($hallName, $hall->getName());
    }

    public function test_create_withValidNotTrimmedName()
    {
        $hallName = ' Main ';
        $hall = new Hall($hallName);
        $this->assertSame(trim($hallName), $hall->getName());
    }

    public function test_create_withEmptyName()
    {
        $this->expectException(ErrorReporting::class);
        new Hall('');
    }

    public function test_create_withLargeName()
    {
        $this->expectException(ErrorReporting::class);
        new Hall('More then 20 chars length hall name!');
    }

    public function test_setName_withValidName()
    {
        $hall = new Hall('Main');
        $hall->setName('VIP');
        $this->assertEquals('VIP', $hall->getName());
    }

    public function test_setName_withEmptyName()
    {
        $this->expectException(ErrorReporting::class);
        $hall = new Hall('Main');
        $hall->setName('');
    }

    public function test_setName_withLargeName()
    {
        $this->expectException(ErrorReporting::class);
        $hall = new Hall('Main');
        $hall->setName('More then 20 chars length hall name!');
    }

    public function test_getTables_addTable()
    {
        $hall = new Hall('Main');
        $table1 = new Table($hall, 1);

        $hall->addTable($table1);
        $tables = $hall->getTables();

        $this->assertSame($table1, $tables[0]);
    }

    public function test_removeTables()
    {
        $hall = new Hall('Main');
        $table1 = new Table($hall, 1);

        $hall->addTable($table1);
        $tables = $hall->getTables();
        $this->assertEquals(1, $tables->count());

        $hall->removeTable($table1);
        $this->assertEquals(0, $tables->count());
    }
}