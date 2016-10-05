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
//        var_dump($date);
//        die;
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
    
    
    
    public function getTableData($user){
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];
        
       $tableData = $db->where('user',$user, '=', 'allow filtering')->get('projects_log_time');
//       $secondArray = $tableData[0];
//      return $element =  $secondArray['date'];
       return $tableData;
        
    }
    
    
    
    public function getDurationAndDate($user){
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];
        
        $tableData = $this->getTableData($user);
       
        $newArr = [];
        $currentDate;
        $prevDate = NULL;

        foreach ($tableData as $date) {
            
            $totalHours = 0;
            $currentDate = $date['date']->format("Y-m-d");
            
            if ($prevDate != NULL) {
                if ($currentDate === $prevDate) {
                    continue;
                }
            }
            
            foreach ($tableData as $tableRow) {
             
                $time = $tableRow['date']->format("Y-m-d");
                if ($currentDate === $time ) {
                    $totalHours += $tableRow['duration'];
                }
            }
            $prevDate = $currentDate;
            
            $currentTableDate = ["date" => $currentDate, "duration" => $totalHours];
            
            array_push($newArr, $currentTableDate);
        }
        return $newArr;
    }
    
    public function getDateDetails($user, $date) {
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];
        
        $timeZone = $date . '+0000';
        
        $cql = $db->where('user', $user, '=')
            ->where('date', $timeZone, '=')
            ->get('projects_log_time');

        return $cql;
    }

}

