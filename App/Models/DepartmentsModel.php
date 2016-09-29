<?php

namespace App\Models;

class DepartmentsModel
{
	private $name;
	private $description;

	public function __construct($name,$description)
	{
		$this->name = $name;
		$this->description = $description;
	}

	public function verify($name, $description)
	{
		if($name != "" && $description != "")
		{
			return true;
		}
		return false;
	}

	public function getDepartments()
	{
		return array(
			array(
				'Id' => 1,
				'Name' => "Human Resources",
				"Description" => "Da",
			),
			array(
				'Id' => 2,
				'Name' => "Developers",
				"Description" => "Ne",
			),
			array(
				'Id' => 3,
				'Name' => "Management",
				"Description" => "Ok",
			),
		);
	}
}