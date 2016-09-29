<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\ACL;

class RequestController extends Controller
{

    /**
     * @Route('/request')
     * @Name('request.index')
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
        $app->render('requestTimeOff/requestTimeOff.twig', $data);
    }

    /**
     * @Route('/request')
     * @Name('request.post')
     * @Method('POST')
     */
    public function postAction()
    {
        $app = $this->getYee();

        if (!ACL::canAccess($this->getName())) {
            $app->redirect('/');
        }

        // Get Dates
        $from = $app->request()->post('from');
        $to = $app->request()->post('to');
        $type = $app->request()->post('type');

        //Select types values -
        $vacation = 7;
        $sick_leave = 3;

        //Check if all data was sent
        if (!empty($from) && !empty($to) && !empty($type)) {

            // Convert them to date objects
            $dteFrom = new DateTime($from);
            $dteTo = new DateTime($to);

            // Calculate the difference between the two dates
            $dteDiff = $dteFrom->diff($dteTo);

            //Return the result as a string - example '+5' or '-5'
            $result_string = $dteDiff->format('%R%a days');

            //Return the result as an integer to calculate used days
            $str = $result_string[1] . $result_string[2];
            $result_int = intval($str);

            // Check if correct dates are picked
            switch ($result_string[0]) {

                // If time period is correct calculate days according to types
                case '+':
                    if ($type == 'Choose Type') {
                        $response = 'Choose Type !';
                    }
                    if (( ($type == 'Vacation') && ($result_int > $vacation) ) || ( ($type == 'Vacation') && ($result_int == $vacation) )) {
                        $response = 'You can\'t take' . ' ' . $result_int . ' ' . 'vacation days. Only' . ' ' . $vacation . ' ' . 'are allowed !';
                    }
                    if (( ($type == 'Vacation') && ($result_int < $vacation) ) || ( ($type == 'Vacation') && ($result_int == $vacation) )) {
                        $remaining_days = $vacation - $result_int;
                        $response = 'Used days: ' . ' ' . $result_int;
                        $response1 = 'Remaining days: ' . ' ' . $remaining_days;
                    }
                    if (( ($type == 'Sickleave') && ($result_int > $sick_leave) ) || ( ($type == 'Sickleave') && ($result_int == $sick_leave) )) {
                        $response = 'You can\'t take' . ' ' . $result_int . ' ' . 'sick leave days. Only' . ' ' . $sick_leave . ' ' . 'are allowed !';
                    }
                    if (( ($type == 'Sickleave') && ($result_int < $sick_leave) ) || ( ($type == 'Sickleave') && ($result_int == $sick_leave) )) {
                        $remaining_days = $sick_leave - $result_int;
                        $response = 'Used days: ' . ' ' . $result_int;
                        $response1 = 'Remaining days: ' . ' ' . $remaining_days;
                    }
                    break;

                // If time period is incorrect throw error
                case '-':
                    $response = 'Error! Choose new dates!';
                    break;
            }

            //Return response - 'Error' or 'Choose type'
            if (isset($response)) {
                $message = "<div><p> {$response} </p></div>";

                $data = array(
                    'message' => $message,
                );
            }

            //Return response - 'Used days' & 'Remaining Days'
            if (isset($response) && isset($response1)) {
                $message = "<div>
                        <p> {$response} </p>
                        <p> {$response1} </p>
                        </div>";

                $data = array(
                    'message' => $message,
                );
            }

            //Send response to 'request_form.js' file
            echo json_encode($data);
        }
    }
}