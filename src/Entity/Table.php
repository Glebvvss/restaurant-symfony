<?php

namespace App\Entity;

use BadMethodCallException;
use Doctrine\ORM\Mapping as ORM;
use App\Exception\ErrorReporting;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity()
 * @ORM\Table(name="`table`")
 */
class Table
{
    private const INVALID_NUMBER_ERROR_MSG = 'Table number must be more than zero numeric value';

    private const TRY_TO_REMOVE_NOT_EXISTING_RESERVE_ERROR_MSG = 'Try to remove not existing table reserve';

    private const TIME_OF_RESERVE_ALREADY_IN_USE_ERROR_MSG = 'Time of reserve already in use';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $number;

    /**
     * @ORM\ManyToOne(targetEntity="Hall", inversedBy="tables")
     * @ORM\JoinColumn(name="hall_id", referencedColumnName="id")
     */
    private ?Hall $hall = null;

    /**
     * @ORM\OneToMany(targetEntity="Reserve", mappedBy="table", cascade={"persist"})
     */
    private Collection $reserves;

    public function __construct(int $number)
    {
        if ($number < 0) {
            throw new ErrorReporting(static::INVALID_NUMBER_ERROR_MSG);
        }

        $this->reserves = new ArrayCollection();
        $this->number   = $number;
    }

    public function setHall(Hall $hall): void
    {
        if ($this->hall) {
            throw new BadMethodCallException('You cannot override hall in table');
        }

        $this->hall = $hall;
    }

    public function getHall(): Hall
    {
        if (empty($this->hall)) {
            throw new BadMethodCallException('You cannot call getHall method before setHall call');
        }

        return $this->hall;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getReserves(): Collection
    {
        return $this->reserves;
    }

    public function addReserve(Reserve $newReserve): void
    {
        foreach($this->reserves as $reserve) {
            if ($reserve->intersectWith($newReserve)) {
                throw new ErrorReporting(static::TIME_OF_RESERVE_ALREADY_IN_USE_ERROR_MSG);
            }
        }

        $newReserve->setTable($this);
        $this->reserves[] = $newReserve;
    }

    public function removeReserve(Reserve $reserve): void
    {
        if (!$this->reserves->contains($reserve)) {
            throw new ErrorReporting(static::TRY_TO_REMOVE_NOT_EXISTING_RESERVE_ERROR_MSG);
        }

        $this->reserves->removeElement($reserve);
    }
}