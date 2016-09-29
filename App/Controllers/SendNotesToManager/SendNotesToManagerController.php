<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\ACL;

class sendNotesToManagerController extends Controller
{
    /**
     * @Route('/sendNotesToManagerPost')
     * @Name('sendNotesToManagerPost.index')
     * @Method('post')
     */
    public function postAction()
    {
        /** @var Yee\Yee $yee */
        $app = $this->getYee();

        $name = $app->request()->post('name');
        $email = $app->request()->post('email');
        $note = $app->request()->post('description');

        if ($name !== "" && $email !== "" && $note !== "") {
            if (filter_var(trim($email), FILTER_VALIDATE_EMAIL) && preg_match("/[a-zA-Z0-9_+.-]+\@[a-zA-Z]{2,5}\.[a-zA-Z]{2,5}/", $email)) {
                if (strlen($note) <= 300) {
                    $data = array(
                        "boolean" => true
                    );
                } else {
                    $data = array(
                        "message" => "Your note is too much!",
                        "boolean" => false
                    );
                }
            } else {
                $data = array(
                    "message" => "Your email is not correct!",
                    "boolean" => false
                );
            }
        } else {
            $data = array(
                "message" => "Must fill every fields!",
                "boolean" => false
            );
        }
        echo json_encode($data);
    }
}


