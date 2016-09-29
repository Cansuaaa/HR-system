<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\ACL;

class DashboardController extends Controller
{

    /**
     * @Route('/(dashboard)')
     * @Name('account.index')
     */
    public function indexAction()
    {
        /** @var Yee\Yee $yee */
        $app = $this->getYee();

        if (!ACL::canAccess($this->getName())) {
            $app->redirect('/');
        }
        $data = array(
            "languages" => $_SESSION['language']
        );
        if (isset($_SESSION['isLogged']) == true) {
            $app->render('dashboard/show.twig', $data);
        } else {
            $app->redirect('/login');
        }
    }
}