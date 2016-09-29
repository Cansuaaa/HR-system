<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\CalendarModel;

class CalendarController extends Controller
{
    /**
     * @Route('/calendar')
     * @Name('calendar.index')
     */
    public function showCalendar()
    {
        $app = $this->getYee();

        $css = array(
            '/assets/plugins/fullcalendar/dist/fullcalendar.css'
        );

        $js = array(
                "/assets/plugins/fullcalendar/dist/fullcalendar.min.js",
                "/assets/pages/jquery.fullcalendar.js"
        );

        $data = array(
            "javascript" => $js,
            'css' => $css,
            "languages" => $_SESSION['language']
        );
        $app->render('calendar/calendar.twig', $data);
    }

    /**
     * @Route('/calendar/update')
     * @Name('calendarUpdate.index')
     * @Method('get')
     */
    public function updateCalendar()
    {
        $app = $this->getYee();
        $date = $app->request()->get('date');
        $prevTitle = $app->request()->get('prevTitle');
        $type = $app->request()->get('type');
        $content = $app->request()->get('content');

        $model = new CalendarModel($date, $type, $content);
        $data = $model->updateCalendar($prevTitle);
        echo json_encode($data);
    }

    /**
     * @Route('/calendar/delete')
     * @Name('calendarDelete.index')
     * @Method('get')
     */
    public function deleteFromCalendar()
    {
        $app = $this->getYee();
        $date = $app->request()->get('date');
        $type = $app->request()->get('type');
        $content = $app->request()->get('content');
        $model = new CalendarModel($date, $type, $content);
        $data = $model->deleteFromCalendar($_SESSION['userEmail']);
        echo json_encode($data);
    }
}