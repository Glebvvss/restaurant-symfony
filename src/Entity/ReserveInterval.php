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

    private const TIME_NOT_IN_SCHEDULE_ERROR_MSG = 'Time not in restaurant schedule time';

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

        $openingHours = new OpeningHours();
        if ($openingHours->isClosedAt($timeFrom) || $openingHours->isClosedAt($timeTo)) {
            throw new ErrorReporting(static::TIME_NOT_IN_SCHEDULE_ERROR_MSG);
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

        if ($interval->getTimeTo()->getTimestamp() <= $this->timeFrom->getTimestamp()) {
            return false;
        }

        return true;
    }
}