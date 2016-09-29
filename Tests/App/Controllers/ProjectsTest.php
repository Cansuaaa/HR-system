<?php
namespace Tests\App\Controllers;

class ProjectsTest extends \Tests\WebTestCase 
{
	public function testEditWithDummyData()
	{
		$name = "da";
		$action = "edit";
		$id="2";
		$description = "Store";
		$createdBy = "User";

		$data = array(
			"name" => $name,
			"action" => $action,
			"id" => $id,
			"description" => $description,
			"createdBy" => $createdBy,
		);

		$response = $this->runApp('POST', '/ajax/projectsCRUD', $data);
		$jsonData = json_decode((string)$response->getBody(), true);

		$this->assertEquals(true, $jsonData["success"]);
		$this->assertEquals(false, $jsonData["error"]);
	}
	
	public function testEditWithInvalidData()
	{
		$description = "Store";
		$createdBy = "User";
		$name = "";
		$action = "edit";
		$id="";

		$data = array(
			"name" => $name,
			"action" => $action,
			"id" => $id,
			"description" => $description,
			"createdBy" => $createdBy,
		);

		$response = $this->runApp('POST', '/ajax/projectsCRUD', $data);
		$jsonData = json_decode((string)$response->getBody(), true);
		
		$this->assertEquals(false, $jsonData['success']);
		$this->assertEquals(true, $jsonData["error"]);
	}
}