<?php

namespace App\Models;
use App\Models\DepartmentsModel;

class DepartmentsTest extends \Tests\WebTestCase
{
	public function testModelWithDummyData()
	{
		$name = "da";
		$description = "nz";

		$department = new DepartmentsModel($name,$description);

		$result = $department->verify($name,$description);
		$this->assertEquals(true,$result);
	}

	public function testModelWithInvalidData()
	{
		$name = "";
		$description = "";

		$department = new DepartmentsModel($name,$description);

		$result = $department->verify($name,$description);
		$this->assertEquals(false,$result);
	}
}