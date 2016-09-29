<?php
namespace Tests\App\Controllers;

class LoginTest extends \Tests\WebTestCase 
{
	public function testLoginWithDummyData() 
	{
		$username = "kinguin@dev.com";
		$password = "qwerty";

		$data = array(
			"loginEmail" => $username,
			"loginPass" => $password
		);

		$response = $this->runApp('POST', '/ajax/login', $data);
		$jsonData = json_decode((string)$response->getBody(), true);

		$this->assertEquals(true, $jsonData["success"]);
		$this->assertEquals(false, $jsonData["error"]);
	}

	public function testLoginWithInvalidData() 
	{
		$username = "invalid@dev.com";
		$password = "invalid";

		$data = array(
			"loginEmail" => $username,
			"loginPass" => $password
		);

		$response = $this->runApp('POST', '/ajax/login', $data);
		$jsonData = json_decode((string)$response->getBody(), true);
		$this->assertEquals(false, $jsonData['success']);
		$this->assertEquals(true, $jsonData["error"]);
	}
}