<?php

namespace Tests\Models\App;

use App\Models\ACL;

class ACLlTest extends \Tests\WebTestCase
{

    public function testCanAccessLoggedUser()
    {
        ACL::$databaseData = array(
            'test1.index' => 1,
            'test2.index' => 2
        );

        ACL::$session = array(
            'isLogged' => true,
            'status' => 1
        );

        $this->assertEquals(true, ACL::canAccess('test1.index'));
        $this->assertEquals(false, ACL::canAccess('test2.index'));
    }

    public function testCanAccessLoggedAdmin()
    {
        ACL::$databaseData = array(
            'test1.index' => 1,
            'test2.index' => 2
        );

        ACL::$session = array(
            'isLogged' => true,
            'status' => 2
        );

        $this->assertEquals(true, ACL::canAccess('test1.index'));
        $this->assertEquals(true, ACL::canAccess('test2.index'));
    }

    public function testCanAccessUnlogged()
    {
        ACL::$databaseData = array(
            'test1.index' => 1,
            'test2.index' => 2
        );

        ACL::$session = array(
            'isLogged' => false
        );

        $this->assertEquals(false, ACL::canAccess('test1.index'));
        $this->assertEquals(false, ACL::canAccess('test2.index'));
    }
}