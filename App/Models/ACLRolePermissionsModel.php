<?php
namespace App\Models;

class ACLRolePermissionsModel
{
    private $name, $response, $db;

    function __construct($name, $response)
    {
        $this->name = $name;
        $this->response = $response;
        $app = \Yee\Yee::getInstance();
        $this->db = $app->db['cassandra'];
    }

    public function updateACLRolePermissions() {

    }
}