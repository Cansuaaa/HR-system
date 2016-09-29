<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\ACL;

class ChangeLanguageController extends Controller
{

    /**
     * @Route('/language/:language')
     * @Name('language.index')
     */
    public function indexAction($language)
    {
        /** @var Yee\Yee $yee */
        $app = $this->getYee();

        $languagesTable = $app->container->get('differentLanguages');
        setcookie('language', $language, time() + 60*60*24*7, "/");
        $_SESSION['language'] = $languagesTable->getData($language);
        $app->redirect($_SERVER['HTTP_REFERER']);
    }
}

