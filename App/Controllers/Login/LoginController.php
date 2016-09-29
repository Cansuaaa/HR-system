<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\LoginModel;
use App\Models\ACL;


class LoginController extends Controller
{
     /**
     * @Route('/login')
     * @Name('login.index')
     */
    public function indexAction( )
    {
        /** @var Yee\Yee $yee */
        $app = $this->getYee();
        
        if (!ACL::canAccess($this->getName())) {
            $app->redirect('/');
        }
        $javascript = array(
            '/js/login.js',
        );
		
        $data = array(
            "javascript" => $javascript,
            "languages" => $_SESSION['language']
        );

        $app->render('login/login_form.twig', $data);
    }

    /**
     * @Route('/ajax/login')
     * @Name('post.index')
     * @Method('post') 
     */
    public function loginAction() {

        /** @var Yee\Yee $yee */
        $app = $this->getYee();
        
        if (!ACL::canAccess($this->getName())) {
            $app->redirect('/');
        }

        // POST variables
        $loginEmail   = $app->request->post('loginEmail');
        $loginPass    = $app->request->post('loginPass');

        $loginModel = new LoginModel();

        if (!$loginModel->validateData($loginEmail,$loginPass)) 
        {
            $error = "Invalid Email/Password!";
        }

        if(isset($error)) {

            $data = array(
                'message'       => $error,
                'success'       => false,
                'error'         => true,
                );

        } else {

            // Code on next line is equal to(==) = session_start();
            $_SESSION['isLogged'] = true;
            $_SESSION['userEmail'] = $loginEmail;
            $_SESSION['logTime'] = date("Y/m/d h:i:sa");
            $loginModel->logTime( $_SESSION['userEmail'], $_SESSION['logTime'],"Is Login" );

            $data = array(
                'redirectTo'    => "/dashboard",
                'message'       => "Hello, $loginEmail",
                'success'       => true,
                'error'         => false,
                );
        }
        echo json_encode($data);
    }
}
