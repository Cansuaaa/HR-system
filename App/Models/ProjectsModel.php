<?php

namespace App\Models;

class ProjectsModel
{
	private $name;
	private $description;
	private $createdBy;

	public function __construct($name,$description,$createdBy)
	{
		$this->name = $name;
		$this->description = $description;
		$this->createdBy = $createdBy;
	}
	
	public function verify($name)
	{
		if($name != "")
		{
			return true;
		}
		return false;
	}
	
	public function getProjects()
	{
		return array (
			array(
				'id' => 1,
				'name' => "Project 1",
				'description' => "HR System",
				'createdBy' => "User1",
				'departments' => array(15),
			),
			array(
				'id' => 2,
				'name' => "Project 2",
				'description' => "Store",
				'createdBy' => "User2",
				'departments' => array(15,25),
			),
			array(
				'id' => 3,
				'name' => "Project 3",
				'description' => "Social Network",
				'createdBy' => "User3",
				'departments' => array(15,25,35)
			),
		);
	}

	public function getDepartments()
	{
		return array(
			array(
				'departmentId' => 15,
				'departmentName' => "Human Resources"
			),
			array(
				'departmentId' => 25,
				'departmentName' => "Developers"
			),
			array(
				'departmentId' => 35,
				'departmentName' => "Management"
			),
		);
	}
}
