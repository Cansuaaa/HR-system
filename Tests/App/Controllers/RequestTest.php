<?php
/**
 * Created by PhpStorm.
 * User: JUNIOR-2
 * Date: 15.8.2016 г.
 * Time: 11:34
 */
namespace Tests\App\Controllers;

//Testing the calculation of remaining days

class RequestTest extends \Tests\WebTestCase
{
    public function testRequestFormWithValidDatesDefaultType() {

        $from = '08/01/2016';
        $to = '08/02/2016';
        $type = 'Choose Type';

        $data = array(
            'from' => $from,
            'to' => $to,
            'type' => $type,
        );

        $response = $this->runApp('POST', '/request', $data);
        $jsonData = json_decode((string)$response->getBody(), true);
        $compare = "<div><p> Choose Type ! </p></div>";

        $this->assertEquals($compare, $jsonData['message']);
    }

    public function testRequestFormWithInvalidDates() {

        $from = '08/12/2016';
        $to = '08/02/2016';
        //The type doesn't matter as long as the dates are incorrect
        $type = 'Vacation';

        $data = array(
            'from' => $from,
            'to' => $to,
            'type' => $type,
        );

        $response = $this->runApp('POST', '/request', $data);
        $jsonData = json_decode((string)$response->getBody(), true);
        $compare = "<div><p> Error! Choose new dates! </p></div>";

        $this->assertEquals($compare, $jsonData['message']);
    }

    public function testRequestFormWithValidDatesVacationType() {

        $type = 'Vacation';

        // Vacation period is correct
        $from_correct = '08/01/2016';
        $to_correct = '08/05/2016';

        $data_correct = array(
            'from' => $from_correct,
            'to' => $to_correct,
            'type' => $type,
        );

        $response_correct = $this->runApp('POST', '/request', $data_correct);
        $jsonDataCorrect = json_decode((string)$response_correct->getBody(), true);

        $this->assertEmpty(!$jsonDataCorrect);
    }

    public function testRequestFormWithInvalidDatesVacationType() {

        $type = 'Vacation';

        // Vacation period is incorrect
        $from_incorrect = '08/02/2016';
        $to_incorrect = '08/10/2016';

        $data_incorrect = array(
            'from' => $from_incorrect,
            'to' => $to_incorrect,
            'type' => $type,
        );

        $response_incorrect = $this->runApp('POST', '/request', $data_incorrect);
        $jsonDataIncorrect = json_decode((string)$response_incorrect->getBody(), true);

        $this->assertEmpty(!$jsonDataIncorrect);
    }

    public function testRequestFormWithValidDatesSickLeaveType() {

        $type = 'Sickleave';

        // Vacation period is correct
        $from_correct = '08/01/2016';
        $to_correct = '08/02/2016';

        $data_correct = array(
            'from' => $from_correct,
            'to' => $to_correct,
            'type' => $type,
        );

        $response_correct = $this->runApp('POST', '/request', $data_correct);
        $jsonDataCorrect = json_decode((string)$response_correct->getBody(), true);

        $this->assertEmpty(!$jsonDataCorrect);
    }

    public function testRequestFormWithInvalidDatesSickLeaveType() {

        $type = 'Sickleave';

        // Vacation period is correct
        $from_correct = '08/01/2016';
        $to_correct = '08/06/2016';

        $data_correct = array(
            'from' => $from_correct,
            'to' => $to_correct,
            'type' => $type,
        );

        $response_correct = $this->runApp('POST', '/request', $data_correct);
        $jsonDataCorrect = json_decode((string)$response_correct->getBody(), true);
        $this->assertEmpty(!$jsonDataCorrect);
    }
}

