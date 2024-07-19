<?php

namespace App\Service;

class CurrentDate
{
    private const DEFAULT_DATETIME = 'now';

    private const DEFAULT_TIMEZONE = 'Europe/Warsaw';

    private const DEFAULT_DATE_FORMAT = "Y-m-d H:i:s";

    public function __invoke()
    {
        $currentDate = new \DateTime(
            self::DEFAULT_DATETIME, 
            new \DateTimeZone(
                self::DEFAULT_TIMEZONE
            )
        );

        return $currentDate->format(self::DEFAULT_DATE_FORMAT);
    }
}