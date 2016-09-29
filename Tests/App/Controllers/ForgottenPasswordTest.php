<?php

namespace Tests\Controllers\App;

class ForgottenPasswordTest extends \Tests\WebTestCase
{

    public function testGetForgottenPasswordPage()
    {
        $response = $this->runApp('GET', '/forgottenPassword');
        $this->assertEquals(200, $response->getStatus());
        $this->assertContains('END', (string) $response->getBody());
        $this->assertNotContains('START', (string) $response->getBody());
    }

    public function testNotFound()
    {
        $response = $this->runApp('GET', '/forgottenPasswordNotFound');
        $this->assertEquals(404, $response->getStatus());
    }
}