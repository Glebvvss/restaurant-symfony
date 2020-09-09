<?php

namespace App\Entity;

use DateTimeInterface;
use BadMethodCallException;
use Doctrine\ORM\Mapping as ORM;
use App\Common\Exception\ErrorReporting;
use App\Repository\ReserveRepository;

/**
 * @ORM\Entity(repositoryClass=ReserveRepository::class)
 */
class Reserve
{
    private const CLIENT_NAME_MUST_NOT_BE_EMPTY_ERROR_MSG = 'Client name must not be empty';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private string $clientName;

    /**
     * @ORM\ManyToOne(targetEntity="Table", inversedBy="reserves")
     * @ORM\JoinColumn(name="table_id", referencedColumnName="id")
     */
    private ?Table $table = null;

    /**
     * @ORM\Embedded(class="ReserveInterval")
     */
    private ReserveInterval $reserveInterval;

    public function __construct(string $clientName, ReserveInterval $reserveInterval)
    {
        $clientName = trim($clientName);
        if (empty($clientName) || mb_strlen($clientName) > 30) {
            throw new ErrorReporting(static::CLIENT_NAME_MUST_NOT_BE_EMPTY_ERROR_MSG);
        }

        $this->clientName      = $clientName;
        $this->reserveInterval = $reserveInterval;
    }

    public function setTable(Table $table): void
    {
        if ($this->table) {
            throw new BadMethodCallException('You cannot override table in reserve');
        }

        $this->table = $table;
    }

    public function getTable(): Table
    {
        if (empty($this->table)) {
            throw new BadMethodCallException('You cannot call getTable method before setTable call');
        }

        return $this->table;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): string
    {
        return $this->clientName;
    }

    public function getTimeFrom(): DateTimeInterface
    {
        return $this->reserveInterval->getTimeFrom();
    }

    public function getTimeTo(): DateTimeInterface
    {
        return $this->reserveInterval->getTimeTo();
    }

    public function getReserveInterval(): ReserveInterval
    {
        return $this->reserveInterval;
    }

    public function intersectWith(Reserve $reserve): bool
    {
        return $this->reserveInterval->intersectWith($reserve->getReserveInterval());
    }
}