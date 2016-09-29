<?php

namespace Tests\Controllers\App;

class SetNotificationsTest extends \Tests\WebTestCase
{

    public function testGetSetNotificationsPage()
    {
        $response = $this->runApp('GET', '/setnotifications');
        $this->assertEquals(200, $response->getStatus());
        $this->assertContains('END', (string) $response->getBody());
        $this->assertNotContains('START', (string) $response->getBody());
    }

    public function testNotFound()
    {
        $response = $this->runApp('GET', '/setnotificationsNotFound');
        $this->assertEquals(404, $response->getStatus());
    }
}