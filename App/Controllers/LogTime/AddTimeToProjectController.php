<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\ACL;
use App\Models\AddTimeToProjectModel;
use App\Models\ProjectsNameModel;

class AddTimeToProjectController extends Controller {

    /**
     * @Route('/addTime')
     * @Name('addTimeToProject.index')
     */
    public function addTimeToProjectAction() {
        $app = $this->getYee();

        $user = $_SESSION['userEmail'];

        if (!ACL::canAccess($this->getName())) {
            $app->redirect('/');
        }

        $javascript = array(
            '/assets/js/projectsLogtime.js',
            "/assets/pages/datatables.editable.addTime.js"
        );

        $projectsNameModel = new ProjectsNameModel();
        $projectDetails = $projectsNameModel->getProjectName();

        $addTimeToProjectModel = new AddTimeToProjectModel();
        $userData = $addTimeToProjectModel->checkUserData($user);

        $userDuration= $addTimeToProjectModel->checkUsersDuration();
        echo"<pre>";
        var_dump($userDuration);
       die; 
        
        
        
        if ($userData == False) {
            $data = [
                "content" => $projectDetails,
                "javascript" => $javascript,
                "languages" => $_SESSION['language'],
                "css" => ["/assets/css/addTime.css"],
            ];
        } else {
            

//        $date = "08/04/2013";
//        $id; //= "d09d19a9-5196-4651-a307-32bf8c61e408";
//        $duration = 5;
//        $projectName = "HR System";
            $year = '2016';
            $month = '02';
            
            $current = $addTimeToProjectModel->getNumberOfDays($year, $month);
//            echo"<pre>";
//            var_dump($current);
//            die;
            
             $currentMonth = $addTimeToProjectModel->getCurrentMonth($user, $year, $month);
//             echo"<pre>";
//            var_dump($currentMonth);
//            die;
            
            $years = $addTimeToProjectModel->getYears($user);
            $totalDurationAndDate = $addTimeToProjectModel->getTotalDurationAndDate($user, $year, $month);

//        $currentMonth = $addTimeToProjectModel->getCurrentMonth($user, $year, $month);
//        $NumberOfDays = $addTimeToProjectModel->getNumberOfDays($user, $year, $month);
//        var_dump($NumberOfDays);
//        echo"<pre>";
//        var_dump($currentMonth);
//        die;
//       
//        echo'<pre>';
//        var_dump($months);
//        die;
//        $checkProjectAndDate = $addTimeToProjectModel->checkProjectAndDate($user, $date, $projectName);
//        $isIdAdded = $addTimeToProjectModel->isIdAdded($user, $date, $id);
//       
//     // Updates Date's details
//        $editDateDetail = $addTimeToProjectModel->editDateDetail($user, $date, $id, $duration, $projectName);
//        
//     // Deletes details for a particular date
//         $deleteDateDetail = $addTimeToProjectModel->deleteDateDetail($user, $date, $id);
//         
//     //Deletes Date and it's all details 
//        $deleteDate = $addTimeToProjectModel->deleteSelectedtDate($user, $date);
//        
//     // small table date's details
//        $dateDetails = $addTimeToProjectModel->getDateDetails($user, $date);

            $data = [
                "years" => $years,
                "content" => $projectDetails,
                "contentTable" => $totalDurationAndDate,
                "javascript" => $javascript,
                "languages" => $_SESSION['language'],
                "css" => ["/assets/css/addTime.css"],
            ];
        }
        $app->render('addTime/addTime.twig', $data);
    }

    /**
     * @Route('/ajax/projectslogtime')
     * @Name('ajaxProjectsLogtime.index')
     * @Method('post')
     */
    public function postAction() {
        /** @var Yee\Yee $yee */
        $app = $this->getYee();
        $user = $_SESSION['userEmail'];

        if (!ACL::canAccess($this->getName())) {
            $app->redirect('/');
        }

        $projectName = $app->request()->post('project-name');
        $calendarDate = $app->request()->post('calendar-date');
        $hours = $app->request()->post('duration');
        $duration = intval($hours);
        // $id = '70fc3c38-474a-498a-b175-3bf7570cbb6f';

        $addTimeToProjectModel = new AddTimeToProjectModel();

        $isDateAdded = $addTimeToProjectModel->isDateAdded($user, $calendarDate);
        $validateDuration = $addTimeToProjectModel->validateDuration($duration);
        $duartionField = $addTimeToProjectModel->checkDurationField($hours);
        $validateDateFormat = $addTimeToProjectModel->validateDateFormat($calendarDate);
        $dateCheck = $addTimeToProjectModel->dateCheck($calendarDate);
        $addOrUpdate = TRUE;  //If it is false = Add or if it is true = update

        if ($projectName == "Choose project") {
            $error = 'Please, choose a project!';
        }

        if (!$validateDuration == true) {
            $error = 'Your hours must be between 1 and 12!';
        }

        if (!$duartionField == true) {

            $error = 'The duration field cannot be empty!';
        }

        if (!$validateDateFormat == true) {
            $error = 'The date format is not valid!';
        }

//        if (!$dateCheck == true) {
//            $error = 'Future dates or empty date field aren\'t allowed!';
//        }

        if (!$isDateAdded == true) {

            if (isset($error)) {
                $data = array(
                    'message' => $error,
                    'error' => true,
                    'success' => false,
                );
            } else {
                $addTimeToProjectModel->insertTimeData($user, $projectName, $duration, $calendarDate);
                $data = array(
                    'duration' => $duration,
                    'calendarDate' => $calendarDate,
                    'projectID' => $projectName,
                    'error' => false,
                    'success' => true,
                    'message' => 'You added hours successfully!'
                );
            }
            echo json_encode($data);
        } else {
            $isProjectAndDateAdded = $addTimeToProjectModel->checkProjectAndDate($user, $calendarDate, $projectName);

            if (!$isProjectAndDateAdded == true) {

                $isDurationBiggerThanLimitInsert = $addTimeToProjectModel->checkTotalDurationInsert($user, $calendarDate, $duration);

                if (!$isDurationBiggerThanLimitInsert == true) {
                    $error = 'Your hoursssss must be between 1 and 12! insert';
                }

                if (isset($error)) {
                    $data = array(
                        'message' => $error,
                        'error' => true,
                        'success' => false,
                    );
                } else {
                    $addTimeToProjectModel->insertTimeData($user, $projectName, $duration, $calendarDate);
                    $data = array(
                        'duration' => $duration,
                        'calendarDate' => $calendarDate,
                        'projectID' => $projectName,
                        'error' => false,
                        'success' => true,
                        'message' => 'You added hours and your project successfully!'
                    );
                }
                echo json_encode($data);
            } else {
                $isDurationBiggerThanLimitEdit = $addTimeToProjectModel->checkTotalDurationEdit($user, $calendarDate, $duration, $projectName);

                if ($addOrUpdate == TRUE) {

                    if (!$isDurationBiggerThanLimitEdit == true) {
                        $error = 'Your hoursssss must be between 1 and 12! replace';
                    }

                    if (isset($error)) {
                        $data = array(
                            'message' => $error,
                            'error' => true,
                            'success' => false,
                        );
                    } else {

                        $editDuration = $addTimeToProjectModel->editDuration($user, $calendarDate, $projectName, $duration);
                        $data = array(
                            'duration' => $duration,
                            'calendarDate' => $calendarDate,
                            'projectID' => $projectName,
                            'error' => false,
                            'success' => true,
                            'message' => 'You have edited hours successfully!'
                        );
                    }
                    echo json_encode($data);
                } else {
                    $isDurationBiggerThanLimitInsert = $addTimeToProjectModel->checkTotalDurationInsert($user, $calendarDate, $duration);

                    if (!$isDurationBiggerThanLimitInsert == true) {
                        $error = 'Your hoursssss must be between 1 and 12! replace';
                    }

                    if (isset($error)) {
                        $data = array(
                            'message' => $error,
                            'error' => true,
                            'success' => false,
                        );
                    } else {
                        $addDuration = $addTimeToProjectModel->addDuration($user, $calendarDate, $projectName, $duration);
                        $data = array(
                            'duration' => $duration,
                            'calendarDate' => $calendarDate,
                            'projectID' => $projectName,
                            'error' => false,
                            'success' => true,
                            'message' => 'You have added hours successfully!'
                        );
                    }
                    echo json_encode($data);
                }
            }
        }
    }

    /**
     * @Route('/ajax/projectslogtime/GetInfo')
     * @Name('ajaxProjectsLogtimeGetInfo.index')
     * @Method('GET')
     */
    public function getAction() {
        /** @var Yee\Yee $yee */
        $app = $this->getYee();

        $date = $app->request()->get('date');

        $addTimeToProjectModel = new AddTimeToProjectModel();

        $user = $_SESSION['userEmail'];
        $getDetail = $addTimeToProjectModel->getDateDetails($user, $date);

        echo json_encode($data);
    }

}
