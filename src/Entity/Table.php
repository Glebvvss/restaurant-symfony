<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Exception\ErrorReporting;
use App\Repository\TableRepository;
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
    private ?int $id = null;

    /**
     * @ORM\Column(type="integer")
     */
    private int $number;

    /**
     * @ORM\ManyToOne(targetEntity="Hall", inversedBy="tables")
     * @ORM\JoinColumn(name="hall_id", referencedColumnName="id")
     */
    private Hall $hall;

    /**
     * @ORM\OneToMany(targetEntity="Reserve", mappedBy="table")
     */
    private Collection $reserves;

    public function __construct(int $number)
    {
        $this->reserves = new ArrayCollection();
        $this->setNumber($number);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber(int $number): void
    {
        if ($number < 0) {
            throw new ErrorReporting(static::INVALID_NUMBER_ERROR_MSG);
        }

        $this->number = $number;
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
