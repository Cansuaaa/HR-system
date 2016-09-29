<?php

use App\Models\SettingsModel;
use App\Models\TimezoneModel;
use Yee\Managers\Controller\Controller;
use App\Models\ACL;

class SettingsController extends Controller
{

    /**
     * @Route('/settings')
     * @Name('settings.index')
     */
    public function indexAction()
    {
        $app = $this->getYee();

        $sm = new SettingsModel();
        $connections = $sm->getConnectionTypes();

        $tzm = new TimezoneModel();
        $timezones = $tzm->generate_timezone_list();
        $tzones = $sm->getTimezones();
        $tzm->setLocale( 'bulgarian' );
        $locale = $tzm->getLocale();
        $css = array(
            '/css/custom.css'
        );

        $data = array(
            'timezones' => $timezones,
            'connections' => $connections,
            'tzones' => $tzones,
            'locale' => $locale,
            'css' => $css,
            'languages' => $_SESSION['language']
        );

        $app->render( 'settings/settings.twig', $data );
    }
}
