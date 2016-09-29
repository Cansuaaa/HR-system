<?php
use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\MyAccountModel;
use App\Models\ACL;

class MyAccountController extends Controller
{
    /**
     * @Route('/myAccountPage')
     * @Name('myaccountpage.index')
     */
    public function addTimeToProject()
    {
        $app = $this->getYee();

        if (!ACL::canAccess($this->getName())) {
            $app->redirect('/');
        }

        $data = [
            "javascript" => [
                "/assets/js/bootstrap-editable.min.js",
                "/assets/js/myAccount.js",
            ],
            "css" => [
                '/assets/css/bootstrap-editable.css',
                '/assets/css/myAccount.css',
                'http://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css',
            ],
            "languages" => $_SESSION['language']
        ];

        $app->render('myAccountPage/myProfilePage.twig', $data);
    }

    /**
    * @Route('/ajax/addNewExperience')
    * @Name('myAccountPage.index')
    * @Method('POST')
    */
    public function addNewExperience()
    {
        $app = $this->getYee();
 
        // Post variables
        $companyName = $app->request->post('experienceCompanyName');
        $title = $app->request->post('experienceTitle');
        $location = $app->request->post('locationExperience');
        $monthFrom = $app->request->post('experienceMonthFrom');
        $yearFrom = $app->request->post('experienceYearFrom');
        $monthTo = $app->request->post('experienceMonthTo');
        $yearTo = $app->request->post('experienceYearTo');
        $description = $app->request->post('descriptionExperience');
 
        $myAccountModel = new MyAccountModel();
        $isDataValid =  $myAccountModel->isEmptyVariable($companyName)  ||
                        $myAccountModel->isEmptyVariable($title)        ||
                        $myAccountModel->isEmptyVariable($location)     ||
                        $myAccountModel->isEmptyVariable($monthFrom)    ||
                        $myAccountModel->isEmptyVariable($yearFrom)     ||
                        $myAccountModel->isEmptyVariable($monthTo)      ||
                        $myAccountModel->isEmptyVariable($yearTo);
 
        if ($isDataValid) 
        {
            $error = "Fill every field, before add a new one!";
        }

        if (isset($error)) {
            $data = array(
                'msg' => $error,
                'success' => false,
                'error' => true,
            );
        } else {
            $data = array(
                'msg' => "Experience upload successful",
                'success' => true,
                'error' => false,
            );
        }
        echo json_encode($data);
    }

     /**
      * @Route('/ajax/updateExperience')
      * @Name('myAccountPage.index')
      * @Method('post')
      */
    public function updateExperience()
    {
        $app = $this->getYee();

        $data = array(
            'msg' => 'Experience update!',
        );

        echo json_encode($data);
    }

    /**
      * @Route('/ajax/deleteExperience')
      * @Name('myAccountPage.index')
      * @Method('POST')
      */
    public function deleteExperience()
    {
        $app = $this->getYee();

        $data = array(
            'msg' => 'Experience deleted!',
        );

        echo json_encode($data);
    }


    /**
      * @Route('/ajax/addNewSkill')
      * @Name('myAccountPage.index')
      * @Method('POST')
      */
    public function addNewSkills() 
    {
        $app = $this->getYee();

        // Post variables
        $programLanguage = $app->request->post('addProgramLanguage');
        $experienceInTime = $app->request->post('experienceInTime');

        $myAccountModel = new MyAccountModel();
        $isDataValid =  $myAccountModel->isEmptyVariable($programLanguage)  || 
                        $myAccountModel->isEmptyVariable($experienceInTime);

        if ($isDataValid) 
        {
            $error = "Fill every field, before add a new one!";
        }

        if (isset($error)) {
            $data = array(
                'msg' => $error,
                'success' => false,
                'error' => true,
            );
        } else {
            $data = array(
                'msg' => "Skill upload successful",
                'success' => true,
                'error' => false,
            );
        }
        echo json_encode($data);
    }

     /**
      * @Route('/ajax/updateSkill')
      * @Name('myAccountPage.index')
      * @Method('post')
      */
    public function updateSkill()
    {
        $app = $this->getYee();

        $data = array(
            'msg' => 'Skill update!',
        );

        echo json_encode($data);
    }

    /**
      * @Route('/ajax/deleteSkill')
      * @Name('myAccountPage.index')
      * @Method('post')
      */
    public function deleteSkill()
    {
        $app = $this->getYee();

        $data = array(
            'msg' => 'Skill deleted!',
        );

        echo json_encode($data);
    }
 
     /**
      * @Route('/ajax/addNewProject')
      * @Name('myAccountPage.index')
      * @Method('POST')
      */
    public function addNewProject() 
    {
        $app = $this->getYee();
 
        // Post variables
        $projectName = $app->request->post('projectName');
        $projectYear = $app->request->post('projectYear');
        $projectMonth = $app->request->post('projectMonth');
        $projectURL = $app->request->post('projectURL');
        $description = $app->request->post('description');
        $pattern = "/(https?|ftp):\/\/([a-zA-Z0-9.-]+(:[a-zA-Z0-9.&%$-]+)*@)*((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])){3}|([a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]+\.(com|edu|dev|gov|int|mil|net|bg|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(:[0-9]+)*(\/($|[a-zA-Z0-9.,?'\\+&%$#=~_-]+))*$/";

        $myAccountModel = new MyAccountModel();
        $isDataValid =  $myAccountModel->isEmptyVariable($projectName)  ||
                        $myAccountModel->isEmptyVariable($projectYear)  ||
                        $myAccountModel->isEmptyVariable($projectURL)  ||
                        $myAccountModel->isEmptyVariable($projectMonth);
        if (!$isDataValid) {
            if (preg_match($pattern, trim($projectURL), $data) == false) {
                $error = "Your URL is not correct!";
            }
        } else {
            $error = "Fill every field, before add a new one!";
        }
 
        if (isset($error)) {
            $data = array(
                'msg' => $error,
                'success' => false,
                'error' => true,
            );
        } else {
            $data = array(
                'msg' => "Project upload successful",
                'success' => true,
                'error' => false,
            );
        }
        echo json_encode($data);
    }

     /**
      * @Route('/ajax/updateProject')
      * @Name('myAccountPage.index')
      * @Method('post')
      */
    public function updateProject()
    {
        $app = $this->getYee();

        $data = array(
            'msg' => 'Project update!',
        );

        echo json_encode($data);
    }

    /**
      * @Route('/ajax/deleteProject')
      * @Name('myAccountPage.index')
      * @Method('POST')
      */
    public function deleteProject()
    {
        $app = $this->getYee();

        $data = array(
            'msg' => 'Project deleted!',
        );

        echo json_encode($data);
    }
}