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
    public function getTableData($user) {
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
    public function getTotalDurationAndDate($user) {
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

                if ($currentDate === $time) {
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
                    $id = $tableRow['id'];
                }

                $prevDate = $currentDate;
                $detailsTable = ["date" => $currentDate, "duration" => $duration, 'project_name' => $projectName, 'id' => $id];
                array_push($dateDetails, $detailsTable);
            }
        }
        return $dateDetails;
    }

    /**
     * Checks if the date has already added.
     * 
     * @param type $user
     * @param type $calendarDate
     * @return boolean
     */
    public function isDateAdded($user, $calendarDate) {
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
        if (isset($allData) == true) {
            return true;
        }
        return false;
    }

    /**
     * Checks sum of the  duration for a particular date in the DB and 
     * the sum of the duration in the DB and the value from the insert Form. 
     * 
     * @param type $user
     * @param type $calendarDate
     * @param type $formTotalDuration
     * @return boolean
     */
    public function checkTotalDurationInsert($user, $calendarDate, $formDuration) {
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];

        $dateDB = str_replace('/', '-', $calendarDate);
        $date = date('Y-m-d', strtotime($dateDB));

        $dateDetails = $this->getDateDetails($user, $date);
        $dbTotalDuration = 0;
        $limitedHours = 12;

        foreach ($dateDetails as $arr) {
            $duration = $arr['duration'];
            $dbTotalDuration = $dbTotalDuration + $duration;
        }
        $totalDuration = $dbTotalDuration + $formDuration;

        if ($dbTotalDuration >= $limitedHours) {
            return false;
        } else {
            if ($totalDuration <= $limitedHours) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    
    
    
    public function checkTotalDurationEdit($user, $calendarDate, $formDuration, $id) {
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];
        
        $date = str_replace('/', '-', $calendarDate);
        $dateFormat = date('Y-m-d', strtotime($date));
        $dateDb = $dateFormat . '+0000';
         
        $dateDetails = $this->getDateDetails($user, $dateFormat);
        $dbTotalDuration = 0;
        $limitedHours = 12;
        
        foreach ($dateDetails as $arr) {
            $duration = $arr['duration'];
            $dbTotalDuration = $dbTotalDuration + $duration;
        }
   
        $dataById = $db->where('user', $user, '=')
                ->where('date', $dateDb, '=')
                ->where('id', $id, '=')
                ->get('projects_log_time');
        
        foreach($dataById as $currentRow){
            
         $dbduration = $currentRow['duration'];
        }
        
        $differenceOfDurationDB = $dbTotalDuration - $dbduration;
//        var_dump($differenceOfDurationDB);
        $differenceOfLimitDuration = $limitedHours - $differenceOfDurationDB;
//        var_dump($differenceOfLimitDuration);
//        die;
        if($formDuration <= $differenceOfLimitDuration){
            return true;
        }
        return false;
        }
    
        
        
    
    /**
     * Deletes all details for selected/particular date.
     *  
     * @param type $user
     * @param type $tableDate
     */
    public function deleteSelectedtDate($user, $tableDate){
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];
        
        $date = date('Y-m-d H:i:s', strtotime($tableDate));
        $dbDate = $date . '+0000'; 
        
        $db->where('user', $user)
                ->where('date', $dbDate)      
                ->delete('projects_log_time');
    }
    
    /**
     * Deletes some details for a particular date.
     * 
     * @param type $user
     * @param type $tableDate
     * @param type $id
     */
    public function deleteDateDetail($user, $tableDate, $id){
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];

       $date = date('Y-m-d H:i:s', strtotime($tableDate));
        $dbDate = $date . '+0000';
        
        $db->where('user', $user)
                ->where('date', $dbDate)
                ->where('id', $id)
                ->delete('projects_log_time');   
    }
    
    public function editDateDetail($user, $tableDate, $id, $duration, $projectName){
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];
        
//        $date = date('Y-m-d H:i:s', strtotime($tableDate));
//        $dbDate = $date . '+0000';
        
        
        $date = str_replace('/', '-', $tableDate);
        $dateFormat = date('Y-m-d', strtotime($date));
         $dateDb = $dateFormat . '+0000';
        
        
        $data = Array(
            'duration' => $duration,
            'project_name' => $projectName
        );
        
        $db->where('user', $user)
                ->where('date', $dateDb)
                ->where('id', $id)
                ->update('projects_log_time', $data);
        
    }
    
    public function isIdAdded($user, $dateForm, $id){
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];
        
        $date = str_replace('/', '-', $dateForm);
        $dateFormat = date('Y-m-d', strtotime($date));
         $dateDb = $dateFormat . '+0000';
         
         $allData = $db->where('user', $user, '=')
                ->where('date', $dateDb, '=')
                ->where('id', $id, '=')
                ->get('projects_log_time');
         
//         echo"<pre>";
//         var_dump($allData);
//         die;
         
         if($allData == NULL){
             return false;
         }
         return true;
    }
    
    public function rawQueryYear($user) {
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];
        
        
       $allData = $db->where('user', $user, '=')
               ->get('projects_log_time');
       $allDates = [];
       $prevDate = NULL;
       $currentDate;
      
               foreach($allData as $tablerow){
           $currentDate = $tablerow['date']->format("Y");
           
           if($prevDate != NULL){
               if($currentDate === $prevDate){
                   continue;
               }        
           }
          
           $prevDate = $currentDate;
           
//           $dates = [];
           array_push($allDates, ['date' => $currentDate]);
           
//           $detailsTable = ["date" => $currentDate, "duration" => $duration, 'project_name' => $projectName, 'id' => $id];
       }
       
       
       
       
       echo"<pre>";
        var_dump($allDates);
        die;
    }
    
   
    
    
    
}
