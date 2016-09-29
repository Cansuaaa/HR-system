<?php

namespace App\Models;

use App\Library\DateHelpers;
use Cassandra;

class AddTimeToProjectModel {

    /**
     * Validates the format of the date and the authenticity.
     * @return boolean TRUE -> Date format and authenticity are valid.
     */
    public function validateDateFormat($date) {
        return DateHelpers::validateDateFormat($date);
    }

    /**
     * Checks whether the date is equal or prior to the current date.
     * @return boolean TRUE -> The date is equal or prior to the current date.
     */
    public function dateCheck($date) {
        $format = 'd/m/Y';
        $parsedDate = date_parse_from_format($format, $date);

        if ($parsedDate['year'] != date('Y')) {
            return false;
        }

        if ($parsedDate['month'] > date('m')) {
            return false;
        }

        if ($parsedDate['month'] == date('m') && $parsedDate['day'] > date('d')) {
            return false;
        }
        
        return true;
    }

    /**
     * Validates the duration format and guarantees it's between $from and $to. (Includes $from and $to).
     *
     * @param int $from
     * @param int $to
     * @return boolean  TRUE -> The duration is between $from and $to
     */
    public function validateDuration($duration) {
        $from = intval(1);
        $to = intval(12);

        if ($duration >= $from && $duration <= $to) {
            return true;
        }
        return false;
    }

    public function insertTimeData($user, $project, $duration, $calendarDate) {
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];
        $uuid = new \Cassandra\Uuid();
        $date = str_replace('/', '-', $calendarDate);
        $timeZone = $date . '+0000';
        $tableDetails = array(
            'user' => $user,
            'id' => $uuid,
            'date' => $timeZone,
            'duration' => $duration,
            'project_name' => $project,
        );
        $db->insert('projects_log_time', $tableDetails);
    }

}

