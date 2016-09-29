<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\ACL;

class HomeController extends Controller
{

    /**
     * @Route('/')
     * @Name('home.index')
     */
    public function indexAction()
    {
        /** @var Yee\Yee $yee */
        $app = $this->getYee();

        if (!ACL::canAccess($this->getName())) {
            $app->redirect('/');
        }
        $data = array(
            "languages" => $_SESSION['language'],
        );
        $app->render('home/home.twig', $data);
    }
}
