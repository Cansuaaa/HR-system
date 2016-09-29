<?php

namespace Tests\Models\App;

use App\Models\ProjectsLogTimeModel;

class ProjectsLogTimeModelTest extends \Tests\WebTestCase
{

    public function testValidateDateFormatValid()
    {
        $projectID = '3';
        $date = '02/03/2016';
        $duration = '8';

        $projectsLogTimeModel = new ProjectsLogTimeModel($projectID, $date, $duration);
        $this->assertEquals(true, $projectsLogTimeModel->validateDateFormat());
    }

    public function testValidateDateFormatInvalid()
    {
        $projectID = '3';
        $date = '32/03/2016';
        $duration = '8';

        $projectsLogTimeModel = new ProjectsLogTimeModel($projectID, $date, $duration);
        $this->assertEquals(false, $projectsLogTimeModel->validateDateFormat());
    }

    public function testDateCheckValid()
    {
        $projectID = '3';
        $date = '15/08/2016';
        $duration = '8';

        $projectsLogTimeModel = new ProjectsLogTimeModel($projectID, $date, $duration);
        $this->assertEquals(true, $projectsLogTimeModel->dateCheck());
    }

    public function testDateCheckInvalid()
    {
        $projectID = '3';
        $date = '18/11/2016';
        $duration = '8';

        $projectsLogTimeModel = new ProjectsLogTimeModel($projectID, $date, $duration);
        $this->assertEquals(false, $projectsLogTimeModel->dateCheck());
    }

    public function testDurationValid()
    {
        $projectID = '3';
        $date = '03/03/2014';
        $duration = '8';

        $projectsLogTimeModel = new ProjectsLogTimeModel($projectID, $date, $duration);
        $this->assertEquals(true, $projectsLogTimeModel->validateDuration(1, 12));
    }

    public function testDurationInvalid()
    {
        $projectID = '3';
        $date = '03/03/2014';
        $duration = '16';

        $projectsLogTimeModel = new ProjectsLogTimeModel($projectID, $date, $duration);
        $this->assertEquals(false, $projectsLogTimeModel->validateDuration(1, 12));
    }
}