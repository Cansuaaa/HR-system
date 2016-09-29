<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;

class ManageRolesTreeController extends Controller
{
    /**
     * @Route('/rolesTree')
     * @Name('ManageRolesTree.index')
     */
    public function ManageRolesTreeAction()
    {
        /** @var Yee\Yee $yee */
        $app = $this->getYee();

        $data = [
            "javascript" => [
                "/assets/pages/manageRolesTreeMenu.js"
            ],
            "css" => [
                "/assets/css/manageRolesTree.css"
            ],
            "languages" => $_SESSION['language']
        ];

        $app->render('ManageRolesTree/ManageRolesTree.twig', $data);
    }
}