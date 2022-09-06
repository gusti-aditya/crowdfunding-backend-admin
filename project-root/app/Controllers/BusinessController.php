<?php

namespace App\Controllers;

use Exception;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Business;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use function PHPUnit\Framework\isNull;

class BusinessController extends ResourceController
{

	public function getKey()
	{
		return getenv('TOKEN_SECRET');
	}

	// GET
	public function listBusiness()
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

				$business_obj = new Business();

				$business_data = $business_obj->getBusinessList();

				$response = [
					"status" => 200,
					"message" => "Business list",
					"error" => false,
					"data" => $business_data
				];

				if (isNull($business_data)) {
					$response = [
						"status" => 500,
						"message" => "Data bisnis tidak ditemukan",
						"error" => true,
						"data" => []
					];
				} else {
					$response = [
						"status" => 200,
						"message" => "Business list",
						"error" => false,
						"data" => $business_data
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
	public function listBusinessNoAuth()
	{
		try {


			$business_obj = new Business();

			$business_data = $business_obj->getBusinessList();

			$response = [
				"status" => 200,
				"message" => "Business list",
				"error" => false,
				"data" => $business_data
			];

			if (is_null($business_data)) {
				$response = [
					"status" => 500,
					"message" => "Data bisnis tidak ditemukan",
					"error" => true,
					"data" => []
				];
			} else {
				$response = [
					"status" => 200,
					"message" => "Business list",
					"error" => false,
					"data" => $business_data
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
				"data" => $business_data
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

				$business_obj = new Business();

				$business_data = $business_obj->getById($id);

				if (is_null($business_data)) {
					$response = [
						"status" => 500,
						"message" => "Data bisnis tidak ditemukan",
						"error" => true,
						"data" => []
					];
				} else {
					$response = [
						"status" => 200,
						"message" => "Business list",
						"error" => false,
						"data" => $business_data
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

			$business_obj = new Business();

				$business_data = $business_obj->getById($id);

				if (is_null($business_data)) {
					$response = [
						"status" => 500,
						"message" => "Data bisnis tidak ditemukan",
						"error" => true,
						"data" => []
					];
				} else {
					$response = [
						"status" => 200,
						"message" => "Business list",
						"error" => false,
						"data" => $business_data
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
