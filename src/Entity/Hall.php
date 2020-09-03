<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Exception\ErrorReporting;
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

    public function addTable(Table $table): void
    {
        if ($this->tableWithNumberExists($table->getNumber())) {
            throw new ErrorReporting(static::TABLE_WITH_NUMBER_EXISTS_ERROR_MSG);
        }

        $this->tables[] = $table;
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

    private function tableWithNumberExists(int $number): bool
    {
        foreach($this->tables as $table) {
            if ($table->getNumber() === $number) {
                return true;
            }
        }

        return false;
    }
}
