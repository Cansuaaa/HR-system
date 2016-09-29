<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\ACL;

class ReceiveDataController extends Controller
{

    /**
     * @Route('/receivedata')
     * @Name('receiveData.post')
     * @Method ('POST')
     */
    public function indexAction()
    {
        $app = $this->getYee();

        if (!ACL::canAccess($this->getName())) {
            $app->redirect('/');
        }

        $from = $app->request()->post("from");
        $to = $app->request()->post("to");
        $type = $app->request()->post("type");

        $offdays = array(
            array(
                'from' => $from,
                'to' => $to,
                'type' => $type
            )
        );

        $data = array(
            'offdays' => $offdays,
            "languages" => $_SESSION['language']
        );

        $app->render('/forms/receivedFormData.twig', $data);
    }
}