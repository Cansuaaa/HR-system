<?php

namespace App\Models;

use App\Library\DateHelpers;
use Cassandra;

class AddTimeToProjectModel {

    private $db;

    public function __construct() {
        $app = \Yee\Yee::getInstance();
        $this->db = $app->db['cassandra'];
    }

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
     * Checks if the duration fields is empty.
     * 
     * @param type $hours
     * @return boolean
     */
    public function checkDurationField($hours) {
        if ($hours == '') {
            return false;
        }
        return true;
    }

    /**
     * Checks if a particular project and for a particular date had been added in the DB, before.
     * 
     * @param type $user
     * @param type $dateForm
     * @param type $projectNameForm
     * @return boolean
     */
    public function checkProjectAndDate($user, $dateForm, $projectNameForm) {
        $date = str_replace('/', '-', $dateForm);
        $dateFormat = date('Y-m-d', strtotime($date));
        $dateDb = $dateFormat . '+0000';

        $data = $this->db->where('user', $user, '=')
                ->where('date', $dateDb, '=')
                ->get('projects_log_time');

        foreach ($data as $arr) {
            $projectNameDb = $arr['project_name'];

            if ($projectNameDb === $projectNameForm) {
                return true;
            }
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
        $this->db->insert('projects_log_time', $tableDetails);
    }

    /**
     * Cheks if there is any data for a given user.
     * 
     * @param type $user
     * @return boolean
     */
    public function checkUserData($user) {
        $tableData = $this->db->where('user', $user, '=', 'allow filtering')->get('projects_log_time');
//        var_dump($tableData);
//        die;
        if($tableData == NULL){
            return FALSE;
        }
        return TRUE;
    }
    
    
    /**
     * 
     * @param type $user
     * @returns an array with all the data in from DB table.
     */
    public function getTableData($user) {
        $tableData = $this->db->where('user', $user, '=', 'allow filtering')->get('projects_log_time');
        return $tableData;
    }

    /**
     * 
     * @param type $user
     * @returns an array which contains all added years.
     */
    public function getYears($user) {
        $allData = $this->db->where('user', $user, '=')
                ->get('projects_log_time');
        $allYears = [];
        $prevYear = NULL;
        $currentYear;

        foreach ($allData as $tablerow) {
            $currentYear = $tablerow['date']->format("Y");

            if ($prevYear != NULL) {
                if ($currentYear === $prevYear) {
                    continue;
                }
            }
            $prevYear = $currentYear;
            array_push($allYears, ['year' => $currentYear]);
        }
        return $allYears;
    }

    /**
     * 
     * @param type $user
     * @returns an array which contains all dates for the user. 
     */
    public function getDate($user) {
        $allData = $this->getTableData($user);
        $currentDate;
        $prevDate = NULL;
        $dates = [];

        foreach ($allData as $data) {
            $currentDate = $data['date']->format("Y-m-d");

            if ($prevDate != NULL) {
                if ($currentDate === $prevDate) {
                    continue;
                }
            }

            $prevDate = $currentDate;
            array_push($dates, ['date' => $currentDate]);
        }

        return $dates;
    }

    /**
     * 
     * @param type $user
     * @param type $year
     * @param type $month
     * @returns number of a given month's days.
     */
    public function getNumberOfDays($year, $month) {
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        return $numberOfDays;
    }
    

    /**
     * 
     * @param type $user
     * @param type $year
     * @param type $month
     * @returns array which contains dates for selected or current month and year.
     */
    public function getCurrentMonth($user, $year, $month) {
        $dates = $this->getDate($user);
        $currentMonth = [];
        $prevValue = NULL;
        $currentValue;
        $dateFormat;
        $dbDate;

        $numberOfDays = $this->getNumberOfDays($year, $month);
        $i = $numberOfDays;
        for ($i; $i > 0; $i--) {
            $day = $i;
            $yearAndMonth = $year . '-' . $month . '-' . $day;
            $dateFormat = date('Y-m-d', strtotime($yearAndMonth));

            foreach ($dates as $row) {
                $dbDate = $row['date'];

                if ($dbDate !== $dateFormat) {
                    continue;
                }
                $currentValue = $dbDate;

                if ($prevValue !== NULL) {
                    if ($currentValue == $prevValue) {
                        continue;
                    }
                    $prevValue = $currentValue;
                }
                $arElementDate = $currentValue;
                array_push($currentMonth, ['date' => $arElementDate]);
            }
        }
        return $currentMonth;
    }

    /**
     * 
     * @param type $user
     * @returns an array, which contains total duration for a particular date.
     */
    public function getTotalDurationAndDate($user, $year, $month) {
        $tableData = $this->getTableData($user);
        $totalDurationAndDate = [];
        $currentMonth = $this->getCurrentMonth($user, $year, $month);

        foreach ($currentMonth as $rowMonth) {
            $currMonth = $rowMonth['date'];
            $totalHours = 0;

            foreach ($tableData as $date) {
                $currentDate = $date['date']->format("Y-m-d");
                $duration = $date['duration'];

                if ($currMonth !== $currentDate) {
                    continue;
                }
                $totalHours += $duration;
                $currentDateTable = ["date" => $currentDate, "duration" => $totalHours];
            }
            array_push($totalDurationAndDate, $currentDateTable);
        }
        return $totalDurationAndDate;
    }

    /**
     * 
     * @param type $user
     * @param type $date
     * returns an array with duration's details for a particular date.
     */
    public function getDateDetails($user, $date) {
        $timeZone = $date . '+0000';

        $allData = $this->db->where('user', $user, '=')
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
     * Checks if the date has already been added.
     * 
     * @param type $user
     * @param type $calendarDate
     * @return boolean
     */
    public function isDateAdded($user, $calendarDate) {
        $dateDB = str_replace('/', '-', $calendarDate);
        $date = date('Y-m-d H:i:s', strtotime($dateDB));
        $timeZone = $date . '+0000';

        $allData = $this->db->where('user', $user, '=')
                ->where('date', $timeZone, '=')
                ->get('projects_log_time');

        if (isset($allData) == true) {
            return true;
        }
        return false;
    }

    /**
     * Checks if totalDuration(for a particular date) =< 12, 
     * where totalDuration = totalDuration from DB + the new inserted value of duration. 
     * 
     * @param type $user
     * @param type $calendarDate
     * @param type $formTotalDuration
     * @return boolean
     */
    public function checkTotalDurationInsert($user, $calendarDate, $formDuration) {
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

    /**
     * Checks if totalDuration(for a particular date) =< 12, 
     * where totalDuration = totalDuration from DB + the new edited value of duration.
     * 
     * @param type $user
     * @param type $calendarDate
     * @param type $formDuration
     * @param type $projectName
     * @return boolean
     */
    public function checkTotalDurationEdit($user, $calendarDate, $formDuration, $projectName) {
        $date = str_replace('/', '-', $calendarDate);
        $dateFormat = date('Y-m-d', strtotime($date));
        $dateDb = $dateFormat . '+0000';

        $dateDetails = $this->getDateDetails($user, $dateFormat);
        $id = $this->getId($user, $dateDb, $projectName);
        $dbTotalDuration = 0;
        $limitedHours = 12;

        foreach ($dateDetails as $arr) {
            $duration = $arr['duration'];
            $dbTotalDuration = $dbTotalDuration + $duration;
        }
        $dataById = $this->db->where('user', $user, '=')
                ->where('date', $dateDb, '=')
                ->where('id', $id, '=')
                ->get('projects_log_time');

        foreach ($dataById as $currentRow) {

            $dbDuration = $currentRow['duration'];
        }
        $differenceOfDurationDB = $dbTotalDuration - $dbDuration;
        $differenceOfLimitDuration = $limitedHours - $differenceOfDurationDB;

        if ($formDuration <= $differenceOfLimitDuration) {
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
    public function deleteSelectedtDate($user, $tableDate) {
        $date = date('Y-m-d H:i:s', strtotime($tableDate));
        $dbDate = $date . '+0000';

        $this->db->where('user', $user)
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
    public function deleteDateDetail($user, $tableDate, $id) {
        $date = date('Y-m-d H:i:s', strtotime($tableDate));
        $dbDate = $date . '+0000';

        $this->db->where('user', $user)
                ->where('date', $dbDate)
                ->where('id', $id)
                ->delete('projects_log_time');
    }

    public function getId($user, $date, $projectNameForm) {
        $data = $this->db->where('user', $user, '=')
                ->where('date', $date, '=')
                ->get('projects_log_time');

        $idAndDuration = [];
        foreach ($data as $arr) {
            $projectNameDb = $arr['project_name'];

            if ($projectNameDb === $projectNameForm) {
                $id = $arr['id'];
                return $id;
            }
        }
    }

    /**
     * Edits the duration.
     * 
     * @param type $user
     * @param type $dateForm
     * @param type $projectNameForm
     * @param type $duration
     */
    public function editDuration($user, $dateForm, $projectNameForm, $duration) {
        $date = str_replace('/', '-', $dateForm);
        $dateFormat = date('Y-m-d', strtotime($date));
        $dateDb = $dateFormat . '+0000';

        $id = $this->getId($user, $dateDb, $projectNameForm);
        $data = Array(
            'duration' => $duration,
        );
        $this->db->where('user', $user)
                ->where('date', $dateDb)
                ->where('id', $id)
                ->update('projects_log_time', $data);
    }

    /**
     * Adds hours to the sum of the duration from DB for particular date and project.
     * 
     * @param type $user
     * @param type $dateForm
     * @param type $projectNameForm
     * @param type $duration
     */
    public function addDuration($user, $dateForm, $projectNameForm, $duration) {
        $date = str_replace('/', '-', $dateForm);
        $dateFormat = date('Y-m-d', strtotime($date));
        $dateDb = $dateFormat . '+0000';

        $id = $this->getId($user, $dateDb, $projectNameForm);

        $dataDb = $this->db->where('user', $user)
                ->where('date', $dateDb)
                ->where('id', $id)
                ->getOne('projects_log_time');

        foreach ($dataDb as $row) {
            $currentDbDuration = $row['duration'];
        }
        $totalDuration = $currentDbDuration + $duration;
        $data = Array(
            'duration' => $totalDuration,
        );
        $this->db->where('user', $user)
                ->where('date', $dateDb)
                ->where('id', $id)
                ->update('projects_log_time', $data);
    }
    
//    public function checkUsersDuration(){
//        $allData = $this->db->get('projects_log_time');
//        
//        $currentMonth = date('m');
//        $currentYear = date('Y');
//        $userDurationTable = [];
//        $user;
//        $numberOfDays = $this->getNumberOfDays($currentYear, $currentMonth);
//        
//        foreach($allData as $arr){
//           $currentDate = date('Y-m-d');
//           $dateDb = $arr['date']->format('Y-m-d');
//           $userDb = $arr['user'];
//            
//           if(!$currentDate == $dateDb){
//               continue;
//           }
//          $user = $userDb;
//         
//           array_push($userDurationTable, ["user"=>$userDb, "date" => $dateDb]);
//           
////           echo"<pre>";
////           var_dump($userDuration);
////           die;
//           
//            
//        };
//        
//        return $userDurationTable;
//    }
    
    

}
