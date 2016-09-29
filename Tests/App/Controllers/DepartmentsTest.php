<?php
namespace Tests\App\Controllers;

class DepartmentsTest extends \Tests\WebTestCase
{
	public function testEditWithDummyData()
	{
		$name = "da";
		$action = "edit";
		$id = "2";
		$description = "Store";

		$data = array(
			"name" => $name,
			"action" => $action,
			"id" => $id,
			"description" => $description,
		);

		$response = $this->runApp('POST', '/ajax/departments', $data);
		$jsonData = json_decode((string)$response->getBody(), true);

		$this->assertEquals(true, $jsonData["success"]);
		$this->assertEquals(false, $jsonData["error"]);
	}

	public function testEditWithInvalidData()
	{
		$description = "Store";
		$name = "";
		$action = "edit";
		$id = "";

		$data = array(
			"name" => $name,
			"action" => $action,
			"id" => $id,
			"description" => $description,
		);

		$response = $this->runApp('POST', '/ajax/departments', $data);
		$jsonData = json_decode((string)$response->getBody(), true);

		$this->assertEquals(false, $jsonData['success']);
		$this->assertEquals(true, $jsonData["error"]);
	}
}