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

        if (!ACL::canAccess($this->getName())) {
            $app->redirect('/');
        }

        $javascript = array(
            '/assets/js/projectsLogtime.js',
            "/assets/pages/datatables.editable.addTime.js"
        );

        $projectsNameModel = new ProjectsNameModel();
        $projectDetails = $projectsNameModel->getProjectName();
//        echo"<pre>";
//        var_dump($projectDetails);
//        die;
        $user = $_SESSION['userEmail'];
        $addTimeToProjectModel = new AddTimeToProjectModel();

        $totalDurationAndDate = $addTimeToProjectModel->getTotalDurationAndDate($user);

        $years = $addTimeToProjectModel->getYears($user);


        $date = "08/04/2013";
//       $date = "2016-09-14";
        $id; //= "d09d19a9-5196-4651-a307-32bf8c61e408";
        $duration = 5;
        $projectName = "HR System";

//       $bla = $addTimeToProjectModel->editDuration($user, $date, $duration, $projectName );
//       
//       
//       
//       
//       
//        $checkProjectAndDate = $addTimeToProjectModel->checkProjectAndDate($user, $date, $projectName);
//        var_dump($checkProjectAndDate);
//        die;
//        echo"<pre>";
//        var_dump($years);
//        die;
//        
//        
//        
//        
//        
//        
//        
//        $isIdAdded = $addTimeToProjectModel->isIdAdded($user, $date, $id);
//        var_dump($isIdAdded);
//        die;
//        // updates Date's details
//        $editDateDetail = $addTimeToProjectModel->editDateDetail($user, $date, $id, $duration, $projectName);
        // die;
//        // Deletes details for a particular date
//         $deleteDateDetail = $addTimeToProjectModel->deleteDateDetail($user, $date, $id);
//     // deletes Date and it's all details 
//        $deleteDate = $addTimeToProjectModel->deleteSelectedtDate($user, $date);
//        die;
//        $dateDetails = $addTimeToProjectModel->getDateDetails($user, $date);
//       // small table date's details
//        echo"<pre>";
//        var_dump($dateDetails);
//        die;
//        




        $data = [
            "years" => $years,
            "content" => $projectDetails,
            "contentTable" => $totalDurationAndDate,
            "javascript" => $javascript,
            "languages" => $_SESSION['language'],
            "css" => ["/assets/css/addTime.css"],
        ];

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
        $validateDateFormat = $addTimeToProjectModel->validateDateFormat($calendarDate);
        $dateCheck = $addTimeToProjectModel->dateCheck($calendarDate);
        $addOrUpdate = TRUE;  //If it is false = Add or if it is true = update

        /////////////////////////////////////////////////////////////////////////////////////////////////////

//        if ($projectName == "Choose project") {
//            $error = 'Please, choose a project!';
//        }


        if (!$isDateAdded == true) {

            var_dump('1');
            if (!$validateDuration == true) {
                $error = 'Your hours must be between 1 and 12!';
            }

            if (!$validateDateFormat == true) {
                $error = 'The date format is not valid!';
            }

            if (!$dateCheck == true) {
                $error = 'Future dates or empty date field aren\'t allowed!';
            }

            if (isset($error)) {
                $data = array(
                    'message' => $error,
                    'error' => true,
                    'success' => false,
                );
            } else {

                $addTimeToProjectModel->insertTimeData($user, $projectName, $duration, $calendarDate);
                var_dump('2');
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
var_dump('3');
            $isProjectAndDateAdded = $addTimeToProjectModel->checkProjectAndDate($user, $calendarDate, $projectName);

            if (!$isProjectAndDateAdded == true) {
            
                $isDurationBiggerThanLimitInsert = $addTimeToProjectModel->checkTotalDurationInsert($user, $calendarDate, $duration);

//                if (!$validateDuration == true) { here it isn't needed
//                    $error = 'Your hours must be between 1 and 12!';  
//                }

                if (!$isDurationBiggerThanLimitInsert == true) {
                    $error = 'Your hoursssss must be between 1 and 12! insert';
                }

                if (!$validateDateFormat == true) {
                    $error = 'The date format is not valid!';
                }

                if (!$dateCheck == true) {
                    $error = 'Future dates or empty date field aren\'t allowed!';
                }

                if (isset($error)) {
                    $data = array(
                        'message' => $error,
                        'error' => true,
                        'success' => false,
                    );
                    var_dump('4');
                } else {

                    $addTimeToProjectModel->insertTimeData($user, $projectName, $duration, $calendarDate);
var_dump('5');
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
                var_dump('6');
            } else {
                var_dump('7');
                
                $isDurationBiggerThanLimitEdit = $addTimeToProjectModel->checkTotalDurationEdit($user, $calendarDate, $duration, $projectName);

                if ($addOrUpdate == TRUE) {
                    
                    if (!$validateDuration == true) {
                $error = 'Your hours must be between 1 and 12!';
                    }
                    
                    if(!$isDurationBiggerThanLimitEdit == true){
                        $error = 'Your hoursssss must be between 1 and 12! replace';
                    }

                    if (!$validateDateFormat == true) {
                        $error = 'The date format is not valid!';
                    }

//                    if (!$dateCheck == true) {
//                        $error = 'Future dates or empty date field aren\'t allowed!';
//                    }

                    if (isset($error)) {
                        $data = array(
                            'message' => $error,
                            'error' => true,
                            'success' => false,
                        );
                        var_dump('8');
                    } else {

                        $editDuration = $addTimeToProjectModel->editDuration($user, $calendarDate, $projectName, $duration);
var_dump('9');
                        $data = array(
                            'duration' => $duration,
                            'calendarDate' => $calendarDate,
                            'projectID' => $projectName,
                            'error' => false,
                            'success' => true,
                            'message' => 'You have edited hours successfully!'
                        );
                    }
// var_dump('10a');
                    echo json_encode($data);
                    
                } else {
                    
                    var_dump('11');
                    $isDurationBiggerThanLimitInsert = $addTimeToProjectModel->checkTotalDurationInsert($user, $calendarDate, $duration);
                    
                     if (!$validateDuration == true) {
                $error = 'Your hours must be between 1 and 12!';
                    }
                    
                    if(!$isDurationBiggerThanLimitInsert == true){
                        $error = 'Your hoursssss must be between 1 and 12! replace';
                    }

                    if (!$validateDateFormat == true) {
                        $error = 'The date format is not valid!';
                    }

//                    if (!$dateCheck == true) {
//                        $error = 'Future dates or empty date field aren\'t allowed!';
//                    }

                    if (isset($error)) {
                        $data = array(
                            'message' => $error,
                            'error' => true,
                            'success' => false,
                        );
                        var_dump('11');
                    } else {

                        $addDuration = $addTimeToProjectModel->addDuration($user, $calendarDate, $projectName, $duration);
var_dump('12');
                        $data = array(
                            'duration' => $duration,
                            'calendarDate' => $calendarDate,
                            'projectID' => $projectName,
                            'error' => false,
                            'success' => true,
                            'message' => 'You have added hours successfully!'
                        );
                        var_dump('13');
                    }                    
                    echo json_encode($data);
                    var_dump('14');
                }
                
                
            }
        }
    }

//            ////////////////////////////////////////////
    //                    $editDuration = $addTimeToProjectModel->editDuration($user, $calendarDate, $duration, $projectName);
//                     
//                
//                if ($validationOfTotalDuration != true) {
//                    $error = 'Your hourssss must be between 1 and 12!';
//                }
//            
//                
//                
//                  $checkProjectAndDate = $addTimeToProjectModel->checkProjectAndDate($user, $calendarDate, $projectName);
//                    if($checkProjectAndDate == true){
//                       
//                    $data = array(
//                    'duration' => $duration,
//                    'calendarDate' => $calendarDate,
//                    'projectID' => $projectName,
//                    'error' => false,
//                    'success' => true,
//                    'message' => 'You update duration successfully!'
//                          );
//                    }
//                    ///////////////////////////////////////////////////////////////////////////////////////////
//        }else {
//            
//            $checkTotalDurationEdit = $addTimeToProjectModel->checkTotalDurationEdit($user, $calendarDate, $duration, $id);
//            
//             if ($projectName == "Choose project") {
//                $error = 'Please, choose a project!';
//            }
//
//            if (!$validateDuration == true) {
//                $error = 'Your hours must be between 1 and 12!';
//            }
//
//            if (!$checkTotalDurationEdit == true) {
//                $error = 'Your hours must be between 1 and 12 for this date!';
//            }
//
//            if (isset($error)) {
//                $data = array(
//                    'message' => $error,
//                    'error' => true,
//                    'success' => false
//                );
//            } else {
//                $editDateDetail = $addTimeToProjectModel->editDateDetail($user, $calendarDate, $id, $duration, $projectName);
//
//                $data = array(
//                    'duration' => $duration,
//                    'calendarDate' => $calendarDate,
//                    'projectID' => $projectName,
//                    'error' => false,
//                    'success' => true,
//                    'message' => 'Your update is successful!'
//                );
//            }
//            
//        }
//    /**
//     * @Route('/ajax/projectslogtime/delete')
//     * @Name('ajaxProjectsLogtimeDelete.index')
//     * @Method('post')
//     */
//    public function deleteAction() {
//        /** @var Yee\Yee $yee */
//        $app = $this->getYee();
//
////        if (!ACL::canAccess($this->getName())) {
////            echo 'You cannot do that';
////        }
//
////        $projectID = $app->request()->post('id');
////
////        $data = array(
////            'error' => false,
////            'success' => $projectID
////        );
//        
//        $deleteButton = "1";
//        $addTimeToProjectModel = new AddTimeToProjectModel();
//        if(isset($deleteButton) == true){
//            $deleteCurrentDate = $addTimeToProjectModel->deleteCurrentDate($user, "2016-09-27");
//        }
//        
//        echo json_encode($data);
//    }

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
