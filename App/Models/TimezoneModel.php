<?php

namespace App\Models;

class TimezoneModel
{

    protected $locale;

    function generate_timezone_list()
    {

        //Change the static property to a different value, in order to shorten the range of countries.
        static $regions = array( \DateTimeZone::ALL );

        $timezones = array();
        foreach ( $regions as $region ) {
            $timezones = array_merge( $timezones, \DateTimeZone::listIdentifiers( $region ) );
        }

        $timezone_offsets = array();
        foreach ( $timezones as $timezone ) {
            $tz = new \DateTimeZone( $timezone );
            $timezone_offsets[$timezone] = $tz->getOffset( new \DateTime );
        }

        // sort timezone by offset
        asort( $timezone_offsets );

        $timezone_list = array();
        foreach ( $timezone_offsets as $timezone => $offset ) {
            $offset_prefix = $offset < 0 ? '-' : '+';
            $offset_formatted = gmdate( 'H:i', abs( $offset ) );

            $pretty_offset = "UTC${offset_prefix}${offset_formatted}";

            $timezone_list[$timezone] = "(${pretty_offset}) $timezone";
        }

        return $timezone_list;
    }

    public function setLocale( $loc )
    {
        $this->locale = setlocale( LC_ALL, "$loc" );
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function getZone()
    {
        
    }
}
