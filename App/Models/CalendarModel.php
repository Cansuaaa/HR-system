<?php
namespace App\Models;

class CalendarModel
{
    private $date, $content, $db, $type;

    function __construct($date, $type, $content)
    {
        $this->date = $date;
        $this->type = $type;
        $this->content = $content;
        $app = \Yee\Yee::getInstance();
        $this->db = $app->db['cassandra'];
    }

    public function updateCalendar($prevTitle) {
        if (trim($this->content) !== "") {
//            if ($this->db->where('email', $_SESSION['email'])->where('content', $prevTitle)->getOne('calendar') == null) {
//                $data = array(
//                    'type' => $this->type,
//                    'email' => $_SESSION['userEmail'],
//                    'date' => $this->date,
//                    'content' => $this->content,
//                );
//                $response = $this->db->insert('calendar', $data);
//                if ($response == true) {
//                    return array(
//                        'message' => 'You update the calendar successfully.',
//                        'bool' => true
//                    );
//                } else {
//                    return array(
//                        'message' => 'We have a problem, try again later!',
//                        'bool' => false
//                    );
//                }
//            } else {
                $data = array(
                    'type' => $this->type,
                    'email' => $_SESSION['userEmail'],
                    'date' => $this->date,
                    'content' => $this->content,
                );
                $response = $this->db->insert('calendar', $data);
                if ($response == true) {
                    return array(
                        'message' => 'You update the calendar successfully.',
                        'bool' => true
                    );
                } else {
                    return array(
                        'message' => 'We have a problem, try again later!',
                        'bool' => false
                    );
                }
//            }
        }
        return array(
            'message' => 'You cannot update without content!',
            'bool' => false
        );
    }

    public  function deleteFromCalendar($email) {
        $response = $this->db->where('content', $this->content)->where('email', $email)->delete('calendar');
        if ($response == true) {
            return array(
                'message' => 'You remove successfully.',
                'bool' => true
            );
        } else {
            return array(
                'message' => 'We have a problem, try again later!',
                'bool' => false
            );
        }
    }
}