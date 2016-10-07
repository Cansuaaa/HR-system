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
        
        $date = "2016-10-04";
       
        $dateDetails = $addTimeToProjectModel->getDateDetails($user, $date);
        
        
        
//        $isDateAdded = $addTimeToProjectModel->isDateAdded($user, $date);
//        
//        echo"<pre>";
//        var_dump($isDateAdded);
//        die;
        
        
        
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

        $addTimeToProjectModel = new AddTimeToProjectModel();
        
        
//        $select = $addTimeToProjectModel->getTableData($user);
////        var_dump($select); die;

        $validateDuration = $addTimeToProjectModel->validateDuration($duration);
        $date = "2016-10-04";
        
        
        
//        $isDateAdded = $addTimeToProjectModel->isDateAdded($user, $calendarDate);
        
        $validationOfTotalDuration = $addTimeToProjectModel->checkTotalDuration($user, $calendarDate);
//       var_dump($validationOfTotalDuration);
//        die;
//        die;
//        
//        
//        var_dump($isDateAdded);
//        die;
        
//        if($isDateAdded == true){
//            
//            if(!$validationOfTotalDuration == true){
//                $error = 'Your hourssss must be between 1 and 12!';
//            }
//        }
        
         if(!$validationOfTotalDuration == true){
             
             $error = 'Your hourssss must be between 1 and 12!';    
         }
                
                
        
        
     
        $validateDateFormat = $addTimeToProjectModel->validateDateFormat($calendarDate);
        $dateCheck = $addTimeToProjectModel->dateCheck($calendarDate);

        if (!$validateDuration == true) {
            $error = 'Your hours must be between 1 and 12!';
        }

        if (!$validateDateFormat == true) {
            $error = 'The date format is not valid!';
        }

        if (!$dateCheck == true) {
            $error = 'Future dates aren\'t allowed!';
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

        echo json_encode($data);
    }

    /**
     * @Route('/ajax/projectslogtime/delete')
     * @Name('ajaxProjectsLogtimeDelete.index')
     * @Method('post')
     */
    public function deleteAction() {
        /** @var Yee\Yee $yee */
        $app = $this->getYee();

//        if (!ACL::canAccess($this->getName())) {
//            echo 'You cannot do that';
//        }

//        $projectID = $app->request()->post('id');
//
//        $data = array(
//            'error' => false,
//            'success' => $projectID
//        );
        
        $deleteButton = "1";
        $addTimeToProjectModel = new AddTimeToProjectModel();
        if(isset($deleteButton) == true){
            $deleteCurrentDate = $addTimeToProjectModel->deleteCurrentDate($user, "2016-09-27");
        }
        
        
        
        
        
        
        echo json_encode($data);
    }
//
//    /**
//     * @Route('/ajax/projectslogtime/GetInfo')
//     * @Name('ajaxProjectsLogtimeGetInfo.index')
//     * @Method('GET')
//     */
//    public function getAction() {
//        /** @var Yee\Yee $yee */
//        $app = $this->getYee();
//
//        $date = $app->request()->get('date');
//        
//        $addTimeToPorjectModel = new AddTimeToProjectModel();
//        
////        $user = $_SESSION['userEmail'];
////        $getDetail = $addTimeToPorjectModel->getDateDetails($user, $date);
////        var_dump($getDetail);
////        die;
//       
////        echo json_encode($data);
//    }
}

