<?php

namespace Tests\Controllers\App;

class ConfigureRolesTest extends \Tests\WebTestCase
{

    public function testGetConfigureRolesPage()
    {
        $response = $this->runApp('GET', '/configureRoles');
        $this->assertEquals(200, $response->getStatus());
        $this->assertContains('END', (string) $response->getBody());
        $this->assertNotContains('START', (string) $response->getBody());
    }

    public function testNotFound()
    {
        $response = $this->runApp('GET', '/configureRolesNotFound');
        $this->assertEquals(404, $response->getStatus());
    }
}