<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\ACL;

class ManageTimeRestrictionsController extends Controller
{
    /**
     * @Route('/manageTimeRestrictions')
     * @Name('manageTimeRestrictions.index')
     */
    public function ManageTimeRestrictionsAction()
    {
        $app = $this->getYee();
        
        if (!ACL::canAccess($this->getName())) {
            $app->redirect('/');
        }
        
        $js = array(
            "/assets/pages/datatables.editable.manageTimeRestrictions.js",
        );

        $data = array(
            "javascript" => $js,
            "languages" => $_SESSION['language']
        );
        $app->render('manageTime/manageTimeRestrictions.twig', $data);
    }
}