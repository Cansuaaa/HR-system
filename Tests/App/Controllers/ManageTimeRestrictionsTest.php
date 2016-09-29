<?php

namespace Tests\Controllers\App;

class  ManageTimeRestrictionsTest extends \Tests\WebTestCase
{

    public function testGetManageTimeRestrictionsPage()
    {
        $response = $this->runApp('GET', '/manageTimeRestrictions');
        $this->assertEquals(200, $response->getStatus());
        $this->assertContains('END', (string) $response->getBody());
        $this->assertNotContains('START', (string) $response->getBody());
    }

    public function testNotFound()
    {
        $response = $this->runApp('GET', '/manageTimeRestrictionsNotFound');
        $this->assertEquals(404, $response->getStatus());
    }
}