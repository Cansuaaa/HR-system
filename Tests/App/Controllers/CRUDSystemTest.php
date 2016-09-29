<?php

namespace Tests\Controllers\App;

class CRUDSystemTest extends \Tests\WebTestCase
{

    public function testGetCRUDSystemPage()
    {
        $response = $this->runApp('GET', '/crudTable');
        $this->assertEquals(200, $response->getStatus());
        $this->assertContains('END', (string) $response->getBody());
        $this->assertNotContains('START', (string) $response->getBody());
    }

    public function testNotFound()
    {
        $response = $this->runApp('GET', '/crudTableNotFound');
        $this->assertEquals(404, $response->getStatus());
    }
}