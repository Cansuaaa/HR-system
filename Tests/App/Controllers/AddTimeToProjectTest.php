<?php

namespace Tests\Controllers\App;

class AddTimeToProjectTest extends \Tests\WebTestCase
{

    public function testDateValid()
    {
        $dataTable = array(
            'project-id' => '1',
            'duration' => '8',
            'calendar-date' => '15/08/2016'
        );
        $response = $this->runApp('post', '/ajax/projectslogtime', $dataTable);
        $jsonData = json_decode((string) $response->getBody(), true);

        $this->assertEquals(false, $jsonData['error']);
        $this->assertEquals(true, $jsonData['success']);
    }

    public function testDateInvalid()
    {
        $dataTable = array(
            'project-id' => '1',
            'duration' => '8',
            'calendar-date' => '08/09/2013'
        );
        $response = $this->runApp('post', '/ajax/projectslogtime', $dataTable);
        $jsonData = json_decode((string) $response->getBody(), true);

        $this->assertEquals(true, $jsonData['error']);
        $this->assertEquals(false, $jsonData['success']);
    }

    public function testDurationValid()
    {
        $dataTable = array(
            'project-id' => '1',
            'duration' => '8',
            'calendar-date' => '15/08/2016'
        );
        $response = $this->runApp('post', '/ajax/projectslogtime', $dataTable);
        $jsonData = json_decode((string) $response->getBody(), true);

        $this->assertEquals(false, $jsonData['error']);
        $this->assertEquals(true, $jsonData['success']);
    }

    public function testDurationInvalid()
    {
        $dataTable = array(
            'project-id' => '1',
            'duration' => '-20',
            'calendar-date' => '15/08/2013'
        );
        $response = $this->runApp('post', '/ajax/projectslogtime', $dataTable);
        $jsonData = json_decode((string) $response->getBody(), true);

        $this->assertEquals(true, $jsonData['error']);
        $this->assertEquals(false, $jsonData['success']);
    }
}