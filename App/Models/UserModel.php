<?php

namespace App\Models;
use Yee\Yee;

class UserModel{



    public function editUser($id)
    {
        return "In User $id edit mode view";
    }

    public function getDatabase()
    {
        $users = array(
            array(
                'firstname' => 'Leeroy',
                'type'      => 'Developer',
                'days'      => 32,
                'from'      => '05.03.2017',
                'to'        => '10.03.2017',
                'id'        => 256,
            ),
            array(
                'firstname' => 'Max',
                'type'      => 'Administrator',
                'days'      => 44,
                'from'      => '10.03.2015',
                'to'        => '11.04.2015',
                'id'        => 311,
            ),
            array(
                'firstname' => 'Kite',
                'type'      => 'Human Resource',
                'days'      => 34,
                'from'      => '17.04.2015',
                'to'        => '22.06.2015',
                'id'        => 112,
            ),
            array(
                'firstname' => 'Dorothy',
                'type'      => 'Simple User',
                'days'      => 12,
                'from'      => '22.07.2015',
                'to'        => '13.08.2015',
                'id'        => 33,
            ),
            array(
                'firstname' => 'Leeroy',
                'type'      => 'Developer',
                'days'      => 32,
                'from'      => '05.03.2017',
                'to'        => '10.03.2017',
                'id'        => 367,
            ),
            array(
                'firstname' => 'Max',
                'type'      => 'Administrator',
                'days'      => 44,
                'from'      => '10.03.2015',
                'to'        => '11.04.2015',
                'id'        => 199
            ),
            array(
                'firstname' => 'Kite',
                'type'      => 'Human Resource',
                'days'      => 34,
                'from'      => '17.04.2015',
                'to'        => '22.06.2015',
                'id'        => 959,
            ),
            array(
                'firstname' => 'Dorothy',
                'type'      => 'Simple User',
                'days'      => 12,
                'from'      => '22.07.2015',
                'to'        => '13.08.2015',
                'id'        => 446,
            ),
        );

        return $users;


    }

    public function deleteUser($id)
    {
        return "User $id has been deleted";
    }
}
