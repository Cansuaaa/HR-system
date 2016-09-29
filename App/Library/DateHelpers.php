<?php

namespace App\Library;

class DateHelpers
{

    /**
     * Validates the format of the date, plus the date authenticity.
     * 
     * @param string $date  
     * @param string $format
     * @return boolean TRUE -> The format of the date is valid and the date is authentic.
     */
    public static function validateDateFormat($date, $format = 'd/m/Y')
    {
        $parsedDate = \DateTime::createFromFormat($format, $date);
        return $parsedDate && $parsedDate->format($format) === $date;
    }
}