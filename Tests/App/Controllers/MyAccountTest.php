<?php

namespace Tests\Controllers\App;

class MyAccountTest extends \Tests\WebTestCase
{

    public function testGetMyAccountPage()
    {
        $response = $this->runApp('GET', '/myAccountPage');
        $this->assertEquals(200, $response->getStatus());
        $this->assertContains('END', (string) $response->getBody());
        $this->assertNotContains('START', (string) $response->getBody());
    }

    public function testNotFound()
    {
        $response = $this->runApp('GET', '/myAccountPageNotFound');
        $this->assertEquals(404, $response->getStatus());
    }
}