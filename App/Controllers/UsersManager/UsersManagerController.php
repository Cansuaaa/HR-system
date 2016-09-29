<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\UsersManagerModel;

class UsersManagerController extends Controller
{
    /**
     * @Route('/usersManager')
     * @Name('usersManager.index')
     */
    public function indexAction()
    {
        /** @var Yee\Yee $yee */
        $app = $this->getYee();

        $data = array(
            "languages" => $_SESSION['language'],
            'javascript' => ['/assets/pages/usersManager.js'],
            'contentTable' => $app->db['cassandra']->get('usersprojects')
        );
        $app->render('usersManager/usersManager.twig', $data);
    }

    /**
     * @Route('/deleteUsersManager')
     * @Name('deleteUsersManager.index')
     * @Method('get')
     */
    public function deleteAction()
    {
        /** @var Yee\Yee $yee */
        $app = $this->getYee();
        $name = $app->request()->get('name');
        $email = $app->request()->get('email');
        $manager = $app->request()->get('manager');
        $hr = $app->request()->get('hr');

        $model = new UsersManagerModel($name, $email, $manager, $hr);
        $data = $model->deleteUsersInDB();

        echo json_encode($data);
    }

    /**
     * @Route('/uploadUsersManager')
     * @Name('uploadUsersManager.index')
     * @Method('get')
     */
    public function uploadAction()
    {
        /** @var Yee\Yee $yee */
        $app = $this->getYee();
        $name = $app->request()->get('name');
        $email = $app->request()->get('email');
        $manager = $app->request()->get('manager');
        $hr = $app->request()->get('hr');

        $model = new UsersManagerModel($name, $email, $manager, $hr);
        $data = $model->uploadUsersInDB();
        echo json_encode($data);
    }
}
