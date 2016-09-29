<?php

namespace Tests\Controllers\App;

class ManageRolesTreeTest extends \Tests\WebTestCase
{

    public function testGetManageRolesTreePage()
    {
        $response = $this->runApp('GET', '/rolesTree');
        $this->assertEquals(200, $response->getStatus());
        $this->assertContains('END', (string) $response->getBody());
        $this->assertNotContains('START', (string) $response->getBody());
    }

    public function testNotFound()
    {
        $response = $this->runApp('GET', '/rolesTreeNotFound');
        $this->assertEquals(404, $response->getStatus());
    }
}