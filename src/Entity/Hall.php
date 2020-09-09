<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Common\Exception\ErrorReporting;
use App\Repository\HallRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=HallRepository::class)
 */
class Hall
{
    private const INVALID_NAME_ERROR_MSG = 'Hall name length must not be empty or contains more then 20 symbols';

    private const TABLE_WITH_NUMBER_EXISTS_ERROR_MSG = 'Table with this number already exists';

    private const TRY_TO_DELETE_NON_EXISTING_TABLE_ERROR_MSG = 'Try to delete non existing table';

    private const TABLE_NOT_EXISTS_ERROR_MSG = 'Table no exists';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity="Table", mappedBy="hall", cascade={"persist", "remove"})
     */
    private Collection $tables;

    public function __construct(string $name)
    {
        $this->tables = new ArrayCollection();

        $this->setName($name);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $name = trim($name);

        if (empty($name) || mb_strlen($name) > 20) {
            throw new ErrorReporting(static::INVALID_NAME_ERROR_MSG);
        }

        $this->name = $name;
    }

    public function addTable(Table $newTable): void
    {
        foreach($this->tables as $table) {
            if ($table->getNumber() === $newTable->getNumber()) {
                throw new ErrorReporting(static::TABLE_WITH_NUMBER_EXISTS_ERROR_MSG);
            }
        }

        $newTable->setHall($this);
        $this->tables[] = $newTable;
    }

    public function removeTable(Table $table): void
    {
        if (! $this->tables->contains($table)) {
            throw new ErrorReporting(static::TRY_TO_DELETE_NON_EXISTING_TABLE_ERROR_MSG);
        }

        $this->tables->removeElement($table);
    }

    public function getTables(): Collection
    {
        return $this->tables;
    }

    public function removeTableByNumber(int $number): void
    {
        $this->tables->removeElement(
            $this->getTableByNumber($number)
        );
    }

    public function getTableByNumber(int $number): Table
    {
        $targetTable = $this->tables
                            ->filter(fn($table) => $table->getNumber() === $number)
                            ->first();

        if (empty($targetTable)) {
            throw new ErrorReporting(static::TABLE_NOT_EXISTS_ERROR_MSG);    
        }

        return $targetTable;
    }
}
