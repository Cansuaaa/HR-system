<?php
namespace Tests\Controllers\App;
use App\Models\ApproveUsersModel;
use App\Models\ApproversModel;

class TimeOffTest extends \Tests\WebTestCase
{
   public function testAddTimeAction() {
        
        $from = "08/15/2016";
        $to = "08/25/2016";
        $type = "Vacation";
        
        $data = array(
            "from" => $from,
            "to" => $to,
            "type" => $type,
        );
        
        $response = $this->runApp('POST', '/ajax/add',$data);
        $jsonData = json_decode((string)$response->getBody(),true);
        
        $this->assertEquals($from, $jsonData['from']);
        $this->assertEquals($to, $jsonData['to']);
        $this->assertEquals($type, $jsonData['type']);
        $this->assertEquals('+10 days', $jsonData['days']);
        
    }
}

