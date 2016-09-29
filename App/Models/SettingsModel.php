<?php

namespace App\Models;

use Yee\Yee;

class SettingsModel
{

    public function getTimezones()
    {
        $timezones = array(
            array(
                'timezone' => '1',
                'time_offset' => 'UTC-12',
                'date_format' => '(mm/dd/yyyy)',
                'currency' => 'BG',
                'language' => 'Bulgarian',
                'fdow' => 'Monday'
            ),
            array(
                'timezone' => '2',
                'time_offset' => 'UTC-11',
                'date_format' => '(d.m.yyyy)',
                'currency' => 'EU',
                'language' => 'Australian',
                'fdow' => 'Sunday'
            ),
            array(
                'timezone' => '3',
                'time_offset' => 'UTC-10',
                'date_format' => '(dd-mm-yyyy)',
                'currency' => 'GBP',
                'language' => 'German',
                'fdow' => 'Saturday'
            ),
            array(
                'timezone' => '4',
                'time_offset' => 'UTC-9',
                'date_format' => '(dd/mm/yyyy)',
                'currency' => 'AUD',
                'language' => 'Japanese',
                'fdow' => 'Friday'
            ),
            array(
                'timezone' => '5',
                'time_offset' => 'UTC-8',
                'date_format' => '(yyyy.mm.dd)',
                'currency' => 'BYR',
                'language' => 'French',
                'fdow' => 'Wednesday'
            ),
            array(
                'timezone' => '6',
                'time_offset' => 'UTC-7',
                'date_format' => '(d. month yyyy)',
                'currency' => 'USD',
                'language' => 'Korean',
                'fdow' => 'Tuesday'
            ),
        );
        return $timezones;
    }

    public function getConnectionTypes()
    {
        $connections = array(
            array(
                'type' => 'SSL',
            ),
            array(
                'type' => 'TLS',
            ),
        );
        return $connections;
    }
}
