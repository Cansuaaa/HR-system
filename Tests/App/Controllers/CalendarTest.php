<?php

namespace Tests\Controllers\App;

class CalendarTest extends \Tests\WebTestCase
{

    public function testGetCalendarPage()
    {
        $response = $this->runApp('GET', '/calendar');
        $this->assertEquals(200, $response->getStatus());
        $this->assertContains('END', (string) $response->getBody());
        $this->assertNotContains('START', (string) $response->getBody());
    }

    public function testNotFound()
    {
        $response = $this->runApp('GET', '/calendarNotFound');
        $this->assertEquals(404, $response->getStatus());
    }
}