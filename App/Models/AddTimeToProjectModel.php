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

    /**
     * Inserts the data in the DB.
     * 
     * @param type $user
     * @param type $project
     * @param type $duration
     * @param type $calendarDate
     */
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
    
   /**
    * 
    * @param type $user
    * @returns all data in the DB table.
    */
    
    public function getTableData($user){
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];
        
       $tableData = $db->where('user', $user, '=', 'allow filtering')->get('projects_log_time');
       return $tableData;   
    }
    
    
    /**
     * Gets total duration for particular date.
     * 
     * @param type $user
     * @return array
     */
    public function getTotalDurationAndDate($user){
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];
        
        $tableData = $this->getTableData($user);
       
        $totalDurationAndDate = [];
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
            $currentDateTable = ["date" => $currentDate, "duration" => $totalHours];
            array_push($totalDurationAndDate, $currentDateTable);
        }
        return $totalDurationAndDate;
    }
    
    /**
     * 
     * 
     * @param type $user
     * @param type $date
     * returns an array with duration's details for specific/particular date.
     */
    public function getDateDetails($user, $date) {
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];
        
        $timeZone = $date . '+0000';

        $allData = $db->where('user', $user, '=')
                ->where('date', $timeZone, '=')
                ->get('projects_log_time');

        $dateDetails = [];
        $currentDate;
        $prevDate = NULL;
//       echo"<pre>";
//        var_dump($allData);
//        die;
        foreach ($allData as $row) {
            
            $currentDate = $row['date']->format("Y-m-d");
            
            $duration = 0;
            $projectName = "";

            if ($prevDate != NULL) {
                if ($currentDate === $prevDate) {
                    continue;
                }
            }

            foreach ($allData as $tableRow) {
                $time = $tableRow['date']->format("Y-m-d");
                
                if ($currentDate === $time) {
                    $duration = $tableRow['duration'];
                    $projectName = $tableRow['project_name'];
                }
                
            $prevDate = $currentDate;
            $detailsTable = ["date" => $currentDate, "duration" => $duration, 'project_name' => $projectName];
            array_push($dateDetails, $detailsTable);
            }
        }
        return $dateDetails;
    }
    
    public function isDateAdded($user, $calendarDate){
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];
        
        $dateDB = str_replace('/', '-', $calendarDate);
        $date = date('Y-m-d H:i:s', strtotime($dateDB));
        $timeZone = $date . '+0000'; 
        
        $allData = $db->where('user', $user, '=')
                ->where('date', $timeZone, '=')
                ->get('projects_log_time');
        
//        var_dump(isset($allData));
//        die;
        if (isset($allData) == true ) {
            return true;
        }
        return false;
    }
    
    
    public function checkTotalDuration($user, $calendarDate) {
         $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];
        
        $dateDB = str_replace('/', '-', $calendarDate);        
        $date = date('Y-m-d', strtotime($dateDB));
    
        $dateDetails = $this->getDateDetails($user, $date);
        
        $isDateAdded = $this->isDateAdded($user, $calendarDate);
        
        if($isDateAdded == true){
        
        
        $totalDuration = 0;
        $limitedHours = 12;
        foreach ($dateDetails as $arr) {
            $duration = $arr['duration'];
            $totalDuration = $totalDuration + $duration;
        }
        
        if($totalDuration >= $limitedHours){
            return false;
        } 
        return  true;
        
        } else {
        return false; 
        }
    }
    
    
    
//    public function deleteCurrentDate($user, $tableDate){
//        $app = \Yee\Yee::getInstance();
//        $db = $app->db['cassandra'];
//        
////        $date = $tableDate->format("Y-m-d h:i:s");
//        
//        $date = date('Y-m-d H:i:s', strtotime($tableDate));
//        $timeZone = $date . '+0000'; 
//        
////        var_dump($timeZone);
////        die;
//        $db->where('user', $user)
//                ->where('date', $timeZone)
//                ->delete('project_logs_time');
//    }
}

