<?php

namespace App\Models;

class NotificationsModel
{
    public function notifData()
    {
        $notif = array(
            'name' => 'Test Notifcation',
            'description' => 'The notifications are being tested.',
            'time' => '1 hour ago.'
        );
        return $notif;
    }
}