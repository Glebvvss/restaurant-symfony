<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Exception\ErrorReporting;

/** 
 * @ORM\Embeddable
*/
class ReserveInterval
{
    private const TIME_FROM_GTE_TIME_TO_ERROR_MSG = 'Time from must be lesss then time to';

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $timeFrom;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $timeTo;

    public function __construct(
        DateTimeInterface $timeFrom,
        DateTimeInterface $timeTo
    )
    {
        if ($timeFrom->getTimestamp() >= $timeTo->getTimestamp()) {
            throw new ErrorReporting(static::TIME_FROM_GTE_TIME_TO_ERROR_MSG);
        }
        
        $this->timeFrom = $timeFrom;
        $this->timeTo   = $timeTo;
    }

    public function getTimeFrom(): DateTimeInterface
    {
        return $this->timeFrom;
    }

    public function getTimeTo(): DateTimeInterface
    {
        return $this->timeTo;
    }

    public function intersectWith(ReserveInterval $interval): bool
    {
        if ($this->timeTo->getTimestamp() <= $interval->getTimeFrom()->getTimestamp()) {
            return false;
        }

        if ($interval->timeTo->getTimestamp() <= $this->timeFrom->getTimestamp()) {
            return false;
        }

        return true;
    }
}