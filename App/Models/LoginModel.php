<?php
namespace App\Models;

class LoginModel {

	public function validateData($email, $pass)
	{
		if ($email == "kinguin@dev.com" && $pass == "qwerty") 
		{
			return true;
		}
		return false;
	}

	public function logTime($email, $date, $msg)
	{
		// Save user Email Address and login time into db
	}
}
