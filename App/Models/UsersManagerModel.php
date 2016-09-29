<?php

namespace App\Models;

class UsersManagerModel
{

    private $db,$name, $email, $manager, $hr;

    function __construct($name, $email, $manager, $hr)
    {
        $this->name = $name;
        $this->email = $email;
        $this->manager = $manager;
        $this->hr = $hr;
        $app = \Yee\Yee::getInstance();
        $this->db = $app->db['cassandra'];
    }

    public function uploadUsersInDB()
    {
        if ( $this->name !== "" && $this->email !== "" && $this->manager !== "" && $this->hr !== "" ) {
            if ( $this->db->where( 'email', $this->email )->getOne( 'users' ) !== null ) {
                $data = array(
                    'id' => null,
                    'name' =>  $this->name,
                    'manager' => $this->manager,
                    'email' => $this->email,
                    'hr' => $this->hr
                );
                if ( $this->db->where( 'email', $this->email )->getOne( 'usersprojects' ) !== null ) {
                    $response = $this->db->insert( 'usersprojects', $data );
                    if ( $response ) {
                        return array(
                            'message' => 'You update successfully.',
                            'bool' => true
                        );
                    } else {
                        return array(
                            'message' => 'We have a problem, try again later!',
                            'bool' => false
                        );
                    }
                } else {
                    $response = $this->db->insert( 'usersprojects', $data );
                    if ( $response ) {
                        return array(
                            'message' => 'You add a new successfully.',
                            'bool' => true
                        );
                    } else {
                        return array(
                            'message' => 'We have a problem, try again later!',
                            'bool' => false
                        );
                    }
                }
            } else {
                return array(
                    'bool' => false,
                    'message' => 'We don\'t have this email/person!'
                );
            }
        } else {
            return array(
                'bool' => false,
                'message' => 'Must fill every field!'
            );
        }
    }

    public function deleteUsersInDB()
    {
        if ( $this->name !== "" && $this->email !== "" && $this->manager !== "" && $this->hr !== "" ) {
            $response = $this->db->where( 'email', $this->email )->delete( 'usersprojects' );
            if ( $response ) {
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
        } else {
            return array(
                'message' => 'Cannot delete empty fields!',
                'bool' => false
            );
        }
    }

    public function getAllUsersFromDB()
    {
        return $this->db->get( 'usersprojects' );
    }
}
