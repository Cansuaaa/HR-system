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
        
        $user = $_SESSION['userEmail'];
        $addTimeToProjectModel = new AddTimeToProjectModel();
        
        $totalDurationAndDate = $addTimeToProjectModel->getTotalDurationAndDate($user);
        
//        $date = "02/09/2016";
//       $date = "2016-09-14";
        $id = "d09d19a9-5196-4651-a307-32bf8c61e408";
        $duration = 5;
        $projectName = "Heyyyy";
        
        
        $years = $addTimeToProjectModel->rawQueryYear($user);
        
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
        $id = 'dd22852d-4cc5-44aa-99fd-d05d06defcb9';
 
        $addTimeToProjectModel = new AddTimeToProjectModel();
   
        $isDateAdded = $addTimeToProjectModel->isDateAdded($user, $calendarDate);
        $validateDuration = $addTimeToProjectModel->validateDuration($duration);
        $validateDateFormat = $addTimeToProjectModel->validateDateFormat($calendarDate);
        $dateCheck = $addTimeToProjectModel->dateCheck($calendarDate);

        
            
//         $isIdAdded = $addTimeToProjectModel->isIdAdded($user, $calendarDate, $id);
         
         
//        if (!$isIdAdded == true) {
          if($id ==''){
              
            if ($projectName == "Choose project") {
                $error = 'Please, choose a project!';
            }

            if ($isDateAdded == true) {
                $validationOfTotalDuration = $addTimeToProjectModel->checkTotalDurationInsert($user, $calendarDate, $duration);
                if ($validationOfTotalDuration != true) {
                    $error = 'Your hourssss must be between 1 and 12!';
                }
            }

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
                    'success' => false
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
            
        }else {
            
            $checkTotalDurationEdit = $addTimeToProjectModel->checkTotalDurationEdit($user, $calendarDate, $duration, $id);
            
             if ($projectName == "Choose project") {
                $error = 'Please, choose a project!';
            }

            if (!$validateDuration == true) {
                $error = 'Your hours must be between 1 and 12!';
            }

            if (!$checkTotalDurationEdit == true) {
                $error = 'Your hours must be between 1 and 12 for this date!';
            }

            if (isset($error)) {
                $data = array(
                    'message' => $error,
                    'error' => true,
                    'success' => false
                );
            } else {
                $editDateDetail = $addTimeToProjectModel->editDateDetail($user, $calendarDate, $id, $duration, $projectName);

                $data = array(
                    'duration' => $duration,
                    'calendarDate' => $calendarDate,
                    'projectID' => $projectName,
                    'error' => false,
                    'success' => true,
                    'message' => 'Your update is successful!'
                );
            }
            
        }

        echo json_encode($data);
    }

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

