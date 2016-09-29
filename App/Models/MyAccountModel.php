<?php
namespace App\Models;

class MyAccountModel 
{
	private $app;

	public function __construct()
	{
		$this->app = \Yee\Yee::getInstance();
	}
	
	/**
	* @param array $data
	* @param string $table table in db where u want to add
	*/
	public function add($data, $table)
	{
		//add new experience/project or skill in db
	}

	/**
	* @param int $id wich u want to update
	* @param string $table table in db where u want to update
	*/
	public function update($id, $table)
	{
		//update experience/project or skill in db
	}

	/**
	* @param int $data
	* @param string $table table in db from where u want to delete
	*/
	public function delete($id, $table)
	{
		//delete experience/project or skill in db
	}

	/**
	 * @param mixed $variable
	 * @return boolean True if variable is empty
	 */
	public function isEmptyVariable($variable)
	{	
		if (empty(trim($variable))) {
			return true;
		}
		return false;
	}

}