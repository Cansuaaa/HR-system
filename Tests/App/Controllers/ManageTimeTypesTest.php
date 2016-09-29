<?php

namespace Tests\Controllers\App;

class ManageTimeTypesTest extends \Tests\WebTestCase
{

    public function testGetManageTimeTypesPage()
    {
        $response = $this->runApp('GET', '/manageTimeTypes');
        $this->assertEquals(200, $response->getStatus());
        $this->assertContains('END', (string) $response->getBody());
        $this->assertNotContains('START', (string) $response->getBody());
    }

    public function testNotFound()
    {
        $response = $this->runApp('GET', '/manageTimeTypesNotFound');
        $this->assertEquals(404, $response->getStatus());
    }
}