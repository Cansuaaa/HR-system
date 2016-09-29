<?php

namespace App\Models;
use App\Models\ProjectsModel;

class ProjectsTest extends \Tests\WebTestCase
{
	public function testModelWithDummyData()
	{
		$name = "da";
		$createdBy = "User";
		$description = "Store";

		$project = new ProjectsModel($name,$description,$createdBy);

		$result = $project->verify($name);
		$this->assertEquals(true,$result);
	}

	public function testModelWithInvalidData()
	{
		$name = "";
		$createdBy = "";
		$description = "";

		$project = new ProjectsModel($name,$description,$createdBy);

		$result = $project->verify($name);
		$this->assertEquals(false,$result);
	}
}
