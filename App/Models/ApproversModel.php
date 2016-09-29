<?php

namespace App\Models;
use Yee\Yee;

class ApproversModel
{
    public function getDatabase()
    {
        $approvers = array(
            array(
                'Name' => 'Alexander',
            ),
            array(
                'Name' => 'Will',
            ),
            array(
                'Name' => 'Jason',
            ),
            array(
                'Name' => 'Natalie'
            )
        );
        
        return $approvers;
    }

    public function returnDatabase()
    {
        $approvers = new ApproversModel();
        $getapprovers = $approvers->getDatabase();

        if(!empty($getapprovers))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}
