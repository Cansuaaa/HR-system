<?php

namespace App\Models;
use Yee\Yee;

class ApproveUsersModel
{
    //setting hardcoded timeoffs
    public function getDatabase()
    {
        $users = array(
            array(
                'id' => '1',
                'fromdate'=>'08/11/2016',
                'todate'=>'18/11/2016',
                'type'=>'vacation',
                'daysoff'=>'10',
                'remaining'=>'0',
                'email'=>'asd@asd.ds',
                'description' => 'I need some timeoff...',
                'approvers' => array('Will', 'Jason'),
                'status'=>'Waiting for a confirmation...'
            ),

            array(
                'id' => '2',
                'fromdate'=>'05/12/2016',
                'todate'=>'08/11/2016',
                'type'=>'sick leave',
                'daysoff'=>'3',
                'remaining'=>'12',
                'email'=>'asd@asd.ds',
                'description' => 'I need some timeoff...',
                'approvers' => array('Natalie', 'Jason'),
                'status'=>'Waiting for a confirmation...'
            ),

            array(
                'id' => '3',
                'fromdate'=>'12/07/2016',
                'todate'=>'23/11/2016',
                'type'=>'vacation',
                'daysoff'=>'11',
                'remaining'=>'4',
                'email'=>'asd@asd.ds',
                'description' => 'I need some timeoff...',
                'approvers' => array('Natalie', 'Will'),
                'status'=>'Waiting for a confirmation....'
            ),

            array(
                'id' => '4',
                'fromdate'=>'24/10/2016',
                'todate'=>'31/11/2016',
                'type'=>'payed off',
                'daysoff'=>'7',
                'remaining'=>'3',
                'email'=>'asd@asd.ds',
                'description' => 'I need some timeoff...',
                'approvers' => array('Natalie', 'Jason'),
                'status'=>'Waiting for a confirmation...'
            ),

            array(
                'id' => '5',
                'fromdate'=>'15/05/2016',
                'todate'=>'1/06/2016',
                'type'=>'payed off',
                'daysoff'=>'15',
                'remaining'=>'0',
                'email'=>'asd@asd.ds',
                'description' => 'I need some timeoff...',
                'approvers' => array('Alexander', 'Jason'),
                'status'=>'Waiting for a confirmation...'
            ),

            array(
                'id' => '6',
                'fromdate'=>'18/06/2016',
                'todate'=>'21/06/2016',
                'type'=>'payed off',
                'daysoff'=>'3',
                'remaining'=>'12',
                'email'=>'asd@asd.ds',
                'description' => 'I need some timeoff...',
                'approvers' => array('Natalie', 'Jason'),
                'status'=>'Waiting for a confirmation...'
            ),
        );

        return $users;
    }

    //check if data from model can be returned
    public function checkReturndata()
    {
        $data = $this->getDatabase();

        if(!empty($data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //return any data sent by a user for a timeoff
    public function returnData($data)
    {
        if(!empty($data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
