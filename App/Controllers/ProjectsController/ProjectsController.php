<?php

error_reporting(E_ALL);

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\ProjectsModel;
use App\Models\ACL;

class ProjectsController extends Controller
{

    /**
     * @Route('/projects')
     * @Name('projects.index')
     */
    public function indexAction()
    {
        $app = $this->getYee();

        if (!ACL::canAccess($this->getName())) {
            $app->redirect('/');
        }

        $model = new ProjectsModel("New", "HR system", "User");

        $projectsArr = $model->getProjects();
        $departmentsArr = $model->getDepartments();

        $data = array(
            "projects" => $projectsArr,
            "departments" => $departmentsArr,
            "javascript" => [
                "/assets/pages/projects.js"
            ],
            "languages" => $_SESSION['language']
        );

        $app->render('projects/projects.twig', $data);
    }

    /**
     * @Route('/ajax/projectsCRUD')
     * @Name('projectsCRUD.post')
     * @Method('post')
     */
    public function postAction()
    {
        $app = $this->getYee();

        if (!ACL::canAccess($this->getName())) {
            $app->redirect('/');
        }

        $action = $app->request()->post('action');
        $name = $app->request()->post('name');
        $id = $app->request()->post('id');
        $departmentID = $app->request()->post('departmentId');
        $createdBy = $app->request()->post('createdBy');
        $description = $app->request()->post('description');

        if ($name != "" && $action == "edit" && $id == "2") {
            $data = array(
                "name" => $name,
                "action" => $action,
                "id" => $id,
                "departmentId" => $departmentID,
                "createdBy" => $createdBy,
                "description" => $description,
                "success" => true,
                "error" => false
            );
        } else {
            $data = array(
                "name" => $name,
                "action" => $action,
                "id" => $id,
                "departmentId" => $departmentID,
                "createdBy" => $createdBy,
                "description" => $description,
                "success" => false,
                "error" => true
            );
        }

        echo json_encode($data);
    }
}