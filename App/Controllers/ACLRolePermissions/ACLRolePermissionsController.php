<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\ACLRolePermissionsModel;

class ACLRolePermissionsController extends Controller
{

    /**
     * @Route('/ACLRolePermissions')
     * @Name('ACLRolePermissions.index')
     */
    public function ACLRolePermissions()
    {
        $app = $this->getYee();

        $js = array(
            "/assets/pages/ACLRolePermissionsTable.js",
        );
        $css = array(
            '/assets/css/ACLRolePermissions.css',
        );
        $data = array(
            "javascript" => $js,
            "css" => $css,
            "languages" => $_SESSION['language'],
            'tableContent' => $app->db['cassandra']->get('acl_profile_permissions')
        );
        $app->render('ACLRolePermissions/ACLRolePermissions.twig', $data);
    }

    /**
     * @Route('/ACLRolePermissions/changes')
     * Method('get')
     */
    public function changePermissions()
    {
        $app = $this->getYee();

        $username = $app->request()->get('name');
        $response = $app->request()->get('response');


        echo json_encode($username);
    }
}