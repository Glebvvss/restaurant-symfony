<?php

namespace App\Entity;

use DateTimeInterface;

class OpeningHours
{
    private string $openTime = '08:00';

    private string $closeTime = '23:00';

    public function isOpenedAt(DateTimeInterface $time)
    {
        if (strtotime($time->format('H:i')) < strtotime($this->openTime)) {
            return false;
        }

        if (strtotime($time->format('H:i')) > strtotime($this->closeTime)) {
            return false;
        }

        return true;
    }

    public function isClosedAt(DateTimeInterface $time)
    {
        return ! $this->isOpenedAt($time);
    }
}