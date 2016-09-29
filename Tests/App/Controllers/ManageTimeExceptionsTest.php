<?php

namespace Tests\Controllers\App;

class ManageTimeExceptionsTest extends \Tests\WebTestCase
{

    public function testGetManageTimeExceptionsPage()
    {
        $response = $this->runApp('GET', '/manageTimeExceptions');
        $this->assertEquals(200, $response->getStatus());
        $this->assertContains('END', (string) $response->getBody());
        $this->assertNotContains('START', (string) $response->getBody());
    }

    public function testNotFound()
    {
        $response = $this->runApp('GET', '/manageTimeExceptionsNotFound');
        $this->assertEquals(404, $response->getStatus());
    }
}