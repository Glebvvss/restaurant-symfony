<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReserveRepository;

/**
 * @ORM\Entity(repositoryClass=ReserveRepository::class)
 */
class Reserve
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Table", inversedBy="reserves")
     * @ORM\JoinColumn(name="table_id", referencedColumnName="id")
     */
    private Table $table;

    /**
     * @ORM\Embedded(class="ReserveInterval")
     */
    private ReserveInterval $reserveInterval;

    public function __construct(
        Table $table, 
        ReserveInterval $reserveInterval
    )
    {
        $this->table           = $table;
        $this->reserveInterval = $reserveInterval;
    }

    public function getId(): ?int
    {
        return $this->id;
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
