<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\ACL;

class ManageTimeTypesController extends Controller
{
    /**
     * @Route('/manageTimeTypes')
     * @Name('manageTimeTypes.index')
     */
    public function manageTimeTypes()
    {
        $app = $this->getYee();
        
        if (!ACL::canAccess($this->getName())) {
            $app->redirect('/');
        }
        
        $js = array(
            "/assets/pages/datatables.editable.manageTimeTypes.js"
        );

        $data = array(
            "javascript" => $js,
            "languages" => $_SESSION['language']
        );

        $app->render('manageTime/manageTimeTypes.twig', $data);
    }
}