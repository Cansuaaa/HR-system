<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\ACL;

class ForgottenPasswordController extends Controller
{

    /**
     * @Route('/forgottenPassword')
     * @Name('forgottenPassword.index')
     */
    public function forgottenPasswordAction()
    {
        /** @var Yee\Yee $yee */
        $app = $this->getYee();

        if (!ACL::canAccess($this->getName())) {
            $app->redirect('/');
        }
        $data = array(
            "languages" => $_SESSION['language'],
        );

        $app->render('forgottenPassword/forgottenPassword.twig', $data);
    }
}