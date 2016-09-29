<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\ACL;

class ManageTimeExceptionsController extends Controller
{
    /**
     * @Route('/manageTimeExceptions')
     * @Name('manageTimeExceptions.index')
     */
    public function manageTimeExceptions()
    {
        $app = $this->getYee();
        
        if (!ACL::canAccess($this->getName())) {
            $app->redirect('/');
        }
        
        $js = array(
            "/assets/pages/datatables.editable.manageTimeExceptions.js",
        );
        
        $data = array(
            "javascript" => $js,
            "languages" => $_SESSION['language']
        );
        $app->render('manageTime/manageTimeExceptions.twig', $data);
    }
}