<?php

namespace Tests\Models\App;

use App\Models\ApproversModel;

class ApproversTest extends \Tests\WebTestCase
{
    //test if approvers' database can be output
    public function testGetApproversDatabase()
    {
        $approvers = new ApproversModel();
        $getapprovers = $approvers->returnDatabase();
        
        $this->assertEquals(true,$getapprovers);
    }
}