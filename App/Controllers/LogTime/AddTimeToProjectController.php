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
        
//        $arr = [ array("user" => "a", "lastN" => "asd"),
//                array("user" => "b", "lastN" => "aasd"),
//                array("user" => "c", "lastN" => "sdd"),
//                array("user" => "d", "lastN" => "ad"),
//            ];
//            foreach ($arr as $elem) {
//                var_dump($elem['user']);
//                echo "<br>";
//                
//            }
//            die;

        $javascript = array(
            '/assets/js/projectsLogtime.js',
            "/assets/pages/datatables.editable.addTime.js"
        );

        $projectsNameModel = new ProjectsNameModel();
        $projectDetails = $projectsNameModel->getProjectName();
        $data = [
            "content" => $projectDetails,
            "javascript" => $javascript,
            "languages" => $_SESSION['language'],
            "css" => ["/assets/css/addTime.css"]
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
        $validateDuration = $addTimeToProjectModel->validateDuration($duration);
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

        if (!ACL::canAccess($this->getName())) {
            echo 'You cannot do that';
        }

        $projectID = $app->request()->post('id');

        $data = array(
            'error' => false,
            'success' => $projectID
        );

        echo json_encode($data);
    }

}

