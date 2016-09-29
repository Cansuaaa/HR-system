<?php

namespace App\Models;

class ACL
{
    //Temporary session (must be deleted later on).
    public static $session = array(
        'isLogged' => true,
        'status' => 2       // 1-> user, 2->admin, 3->supervisor
    );
    
    public static function canAccess($controllerName)
    {
        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];
        $result = $db->where('controller_name', $controllerName)->getOne('acls');

        if (!self::$session['isLogged']) {
            return false;
        }

        if (self::$session['status'] == 2) {
            return true;
        }

        if (self::$session['status'] == 1) {
            if ($result['group'] == 1) {
                return true;
            } else {
                return false;
            }
        }
        
        if (self::$session['status'] == 3) {
            if ($result['group'] == 3 || $result['group'] == 1) {
                return true;
            } else {
                return false;
            }
        }
    }
}
