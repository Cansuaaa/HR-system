<?php

error_reporting(E_ALL);

use Yee\Managers\Controller\Controller;
use Yee\Managers\CacheManager;
use App\Models\DepartmentsModel;

class DepartmentsController extends Controller
{
	/**
	 * @Route('/departments')
	 * @Name('departments.index')
	 */
	public function index()
	{
		$app=$this->getYee();

		$model = new DepartmentsModel("da","da");

		$departmentsArr = $model->getDepartments();

		$data = array(
			"departments" => $departmentsArr,
			"javascript" => [
				"/assets/pages/departments.js"
			],
            "languages" => $_SESSION['language']
        );

		$app->render("departments/departments.twig", $data);
	}

	/**
	 * @Route('/ajax/departments')
	 * @Name('departments.post')
	 * @Method('post')
	 */
	public function post()
	{
		$app = $this->getYee();

		$name = $app->request()->post('name');
		$id = $app->request()->post('id');
		$description = $app->request()->post('description');
		$action = $app->request()->post('action');

		if($name != "" && $action == "edit" && $id == "2")
		{
			$data = array(
				"name" => $name,
				"action" => $action,
				"id" => $id,
				"description" => $description,
				"success" => true,
				"error" => false
			);
		}
		else
		{
			$data = array(
				"name" => $name,
				"action" => $action,
				"id" => $id,
				"description" => $description,
				"success" => false,
				"error" => true
			);
		}

		echo json_encode($data);

	}
}
