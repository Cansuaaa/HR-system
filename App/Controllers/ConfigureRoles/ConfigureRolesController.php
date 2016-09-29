<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\ACL;

class ConfigureRolesControllerController extends Controller
{
    /**
     * @Route('/configureRoles')
     * @Name('ConfigureRolesController.index')
     */
    public function ConfigureRolesControllerAction()
    {
        /** @var Yee\Yee $yee */
        $app = $this->getYee();

        if (!ACL::canAccess($this->getName())) {
            $app->redirect('/');
        }

        $data = [
            "javascript" => [
                "/assets/pages/datatables.editable.configureRoles.js"
            ],
            "languages" => $_SESSION['language']

        ];

        $app->render('configureRoles/configureRoles.twig', $data);
    }
}