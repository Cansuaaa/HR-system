<?php
namespace Tests\App\Models;
use App\Models\LoginModel;

class LoginModelTest extends \Tests\WebTestCase 
{
	public function testLoginValidData() 
	{
		$email = "kinguin@dev.com";
		$pass = "qwerty";

		$loginModel = new LoginModel();
		$result = $loginModel->validateData($email,$pass);

		$this->assertEquals(true, $result);
	}

	public function testLoginInvalidData() 
	{
		$email = "invalid@dev.com";
		$pass = "invalid";

		$loginModel = new LoginModel();
		$result = $loginModel->validateData($email,$pass);

		$this->assertEquals(false, $result);
	}
}