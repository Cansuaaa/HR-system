<?php

namespace App\Models;

use App\Library\DateHelpers;
use Cassandra;

class ProjectsNameModel {

    public function getProjectName() {

        $app = \Yee\Yee::getInstance();
        $db = $app->db['cassandra'];

        return $db->get('projects', null, 'project_name');
    }
}

