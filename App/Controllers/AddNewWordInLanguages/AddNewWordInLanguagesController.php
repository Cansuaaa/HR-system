<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\ACL;

class AddNewWordInLanguagesController extends Controller
{

    /**
     * @Route('/addnewword')
     * @Name('AddNewWordInLanguages.index')
     */
    public function indexAction()
    {
        /** @var Yee\Yee $yee */
        $app = $this->getYee();

        if (!ACL::canAccess($this->getName())) {
            $app->redirect('/');
        }

        $languagesTable = $app->container->get('differentLanguages');
        $newTitle = $app->request()->get('title');
        $newWordEn = $app->request()->get('en');
        $newWordBg = $app->request()->get('bg');

        if ($newTitle !== null) {
            $languagesTable->addNewWord($newTitle, $newWordEn, $newWordBg);
        }

        $data = array("languages" => $_SESSION['language']);
        $app->render('AddNewWordInLanguages/AddNewWordInLanguages.twig', $data);
    }
}

