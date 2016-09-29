<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\NotificationsModel;

class ManageNotificationsController extends Controller
{

    /**
     * method for getting the data for sending notifications
     *
     * @Route('/notify')
     * @Name('notify.post')
     * @Method('POST')
     */
    public function postData()
    {
        $notifModel = new NotificationsModel();
        $getNotif = $notifModel->notifData();

        $data = array(
            'notif' => $getNotif,
            'status' => true
        );

        echo json_encode($data);
    }
}