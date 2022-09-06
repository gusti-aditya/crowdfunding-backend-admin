<?php

namespace App\Controllers;

use Exception;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Portofolio;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use function PHPUnit\Framework\isNull;

class PortofolioController extends ResourceController
{

	public function getKey()
	{
		return getenv('TOKEN_SECRET');
	}

	// GET
	public function listPortofolio()
	{
		try {

			$auth = $this->request->header("Authorization");

			$token = $auth->getValue();

			$id = $this->request->getVar('id');


			$decoded_data = JWT::decode($token, new Key($this->getKey(), 'HS256'));

			$user_id = $decoded_data->userdata->customer_id;

			if (!isset($user_id)) {
				$response = [
					"status" => 500,
					"message" => "User must be login",
					"error" => true,
					"data" => []
				];
			} else {

				$portofolio_obj = new Portofolio();

				$portofolio_data = $portofolio_obj->where('customer_id',$user_id)->get();

				$response = [
					"status" => 200,
					"message" => "Portofolio list",
					"error" => false,
					"data" => $portofolio_data
				];

				if (isNull($portofolio_data)) {
					$response = [
						"status" => 500,
						"message" => "Data portofolio tidak ditemukan",
						"error" => true,
						"data" => []
					];
				} else {
					$response = [
						"status" => 200,
						"message" => "Portofolio list",
						"error" => false,
						"data" => $portofolio_data
					];
				}
			}

			return $this->respondCreated($response);
		} catch (Exception $ex) {

			$response = [
				"status" => 500,
				"message" => $ex->getMessage(),
				"error" => true,
				"data" => []
			];

			return $this->respondCreated($response);
		}

		return $this->respondCreated($response);
	}

	// GET
	public function listPortofolioNoAuth()
	{
		try {


			$portofolio_obj = new Portofolio();

			$portofolio_data = $portofolio_obj->getPortofolioList();

			$response = [
				"status" => 200,
				"message" => "Portofolio list",
				"error" => false,
				"data" => $portofolio_data
			];

			if (is_null($portofolio_data)) {
				$response = [
					"status" => 500,
					"message" => "Data portofolio tidak ditemukan",
					"error" => true,
					"data" => []
				];
			} else {
				$response = [
					"status" => 200,
					"message" => "Portofolio list",
					"error" => false,
					"data" => $portofolio_data
				];
			}

		return $this->respondCreated($response);
		}
		catch(Exception $e)
		{
			$response = [
				"status" => 500,
				"message" => $e,
				"error" => true,
				"data" => $portofolio_data
			];
			return $this->respondCreated($response);
		}
	}


	// GET
	public function getById()
	{
		try {

			$auth = $this->request->header("Authorization");

			$token = $auth->getValue();

			$id = $this->request->getVar('id');


			$decoded_data = JWT::decode($token, new Key($this->getKey(), 'HS256'));

			$user_id = $decoded_data->userdata->customer_id;

			if (!isset($user_id)) {
				$response = [
					"status" => 500,
					"message" => "User must be login",
					"error" => true,
					"data" => []
				];
			} else {

				$portofolio_obj = new Portofolio();

				$portofolio_data = $portofolio_obj->getById($id);

				if (is_null($portofolio_data)) {
					$response = [
						"status" => 500,
						"message" => "Data portofolio tidak ditemukan",
						"error" => true,
						"data" => []
					];
				} else {
					$response = [
						"status" => 200,
						"message" => "Portofolio list",
						"error" => false,
						"data" => $portofolio_data
					];
				}
			}

			return $this->respondCreated($response);
		} catch (Exception $ex) {

			$response = [
				"status" => 500,
				"message" => $ex->getMessage(),
				"error" => true,
				"data" => []
			];

			return $this->respondCreated($response);
		}
		return $this->respondCreated($response);
	}

	// GET
	public function getByIdNoAuth()
	{
		try {

			$id = $this->request->getVar('id');

			$portofolio_obj = new Portofolio();

				$portofolio_data = $portofolio_obj->getById($id);

				if (is_null($portofolio_data)) {
					$response = [
						"status" => 500,
						"message" => "Data portofolio tidak ditemukan",
						"error" => true,
						"data" => []
					];
				} else {
					$response = [
						"status" => 200,
						"message" => "Portofolio list",
						"error" => false,
						"data" => $portofolio_data
					];
				}


			return $this->respondCreated($response);
		} catch (Exception $ex) {

			$response = [
				"status" => 500,
				"message" => $ex->getMessage(),
				"error" => true,
				"data" => []
			];

			return $this->respondCreated($response);
		}
		return $this->respondCreated($response);
	}
}
