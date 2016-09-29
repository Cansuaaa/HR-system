<?php
/**
 * Created by PhpStorm.
 * User: Kristina
 * Date: 24.8.2016 г.
 * Time: 11:42
 */
namespace Tests\Models\App;
use App\Models\ApproveUsersModel;

class ApproveUsersTest extends \Tests\WebTestCase
{
    public function testSubmitedTimeOff()
    {
        //hardcoded submitted data
        $timeoff = array(
                        array(
                                'id' => '11',
                                'fromdate'=>'08/06/2016',
                                'todate'=>'10/06/2016',
                                'type'=>'Sick leave',
                                'daysoff'=>'2',
                                'remaining'=>'18',
                                'email'=>'asd@asd.ds',
                                'description' => 'I need some timeoff...',
                                'approvers' => array('Alexander', 'Jason'),
                                'status'=>'Waiting for a confirmation...'
                            ),
                       );

        $approveUsers = new ApproveUsersModel();
        $this->assertEquals(true, $approveUsers->returnData($timeoff));
    }

    public function testReturnApproveTimeoff()
    {
        $approveUsers = new ApproveUsersModel();
        $getUsersdata = $approveUsers->checkReturndata();
        $this->assertEquals(true, $getUsersdata);
    }
}