<?php

namespace App\Controllers;

use Exception;
use CodeIgniter\RESTful\ResourceController;
use App\Models\Users;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UsersController extends ResourceController
{
	// POST
	public function userRegister()
	{
		$_POST = $this->request->getJSON(true);

		$this->validation =  \Config\Services::validation();
		$this->validation->setRules([
			"first_name" => "required",
			"last_name" => "required",
			"email" => "required|valid_email[users.email]",
			"phone_no" => "required",
			"password" => "required"
		]);
		if (!$this->validation->run($_POST)) {
			// error
			$response = [
				"status" => 500,
				"message" => $this->validation->getErrors(),
				"error" => true,
				"data" => []
			];
		} else {
			// no error
			$email = $_POST["email"];
			$password = $_POST["password"];

			$user_obj = new Users();
			$hashPassword = password_hash($password, PASSWORD_DEFAULT);

			$data = [
				"customer_id" => uniqid(),
				"first_name" =>  $_POST["first_name"],
				"last_name" => $_POST["last_name"],
				"email" =>  $_POST["email"],
				"phone_no" =>  $_POST["phone_no"],
				"password" => $hashPassword
			];

			if ($user_obj->insert($data)) {
				// success
				$user_obj = new Users();

				$userdata = $user_obj->where("email", $email)->first();

				if (!empty($userdata)) {
					// user exists

					if (password_verify($password, $userdata['password'])) {
						// user details matched

						$iat = time();
						$nbf = $iat + 10;
						$exp = $iat + 43200;

						$payload = [
							"iat" => $iat,
							"nbf" => $nbf,
							"exp" => $exp,
							"expired_in" => 43200,
							"userdata" => $userdata
						];

						$token = JWT::encode($payload, $this->getKey(), 'HS256');

						$response = [
							"status" => 200,
							"message" => "User logged in",
							"error" => false,
							"data" => [
								"token" => $token
							]
						];
					} else {
						// password didnt match
						$response = [
							"status" => 500,
							"message" => "Password didn't match",
							"error" => true,
							"data" => []
						];
					}
				} else {
					// user doesnot exists
					$response = [
						"status" => 500,
						"message" => "Invalid details",
						"error" => true,
						"data" => []
					];
				}
			} else {
				// failed to insert
				$response = [
					"status" => 500,
					"message" => "Gagal mendaftarkan user",
					"error" => true,
					"data" => []
				];
			}
		}

		return $this->respondCreated($response);
	}

	// POST
	public function userRegisterBackup()
	{
		$_POST = $this->request->getJSON(true);

		$this->validation =  \Config\Services::validation();
		$this->validation->setRules([
			"first_name" => "required",
			"last_name" => "required",
			"email" => "required|valid_email[users.email]",
			"phone_no" => "required",
			"password" => "required"
		]);

		$rules = [
			"first_name" => "required",
			"last_name" => "required",
			"email" => "required|valid_email[users.email]",
			"phone_no" => "required",
			"password" => "required"
		];

		if (!$this->validation->run($_POST)) {
			// error
			$response = [
				"status" => 500,
				"message" => $this->validator->getErrors(),
				"error" => true,
				"data" => []
			];
		} else {
			// no error
			$user_obj = new Users();
			$hashPassword = password_hash($this->request->getVar("password"), PASSWORD_DEFAULT);

			$data = [
				"customer_id" => uniqid(),
				"first_name" =>  $_POST["first_name"],
				"last_name" => $_POST["last_name"],
				"email" =>  $_POST["email"],
				"phone_no" =>  $_POST["phone_no"],
				"password" => $hashPassword
			];

			if ($user_obj->insert($data)) {
				// success
				$response = [
					"status" => 200,
					"message" => "User berhasil terdaftar",
					"error" => false,
					"data" => []
				];
			} else {
				// failed to insert
				$response = [
					"status" => 500,
					"message" => "Gagal mendaftarkan user",
					"error" => true,
					"data" => []
				];
			}
		}

		return $this->respondCreated($response);
	}

	// POST
	public function userLogin()
	{
		//$_POST = json_decode(file_get_contents("php://input"), true);


		$_POST = $this->request->getJSON(true);

		$this->validation =  \Config\Services::validation();
		$this->validation->setRules([
			'email' => 'required|valid_email',
			'password' => 'required'
		]);


		$rules = [
			"email" => "required|valid_email",
			"password" => "required"
		];

		if (!$this->validation->run($_POST)) {
			// error
			$response = [
				"status" => 500,
				"message" => $this->validator->getErrors(),
				"error" => true,
				"data" => []
			];
		} else {
			// no error
			$email = $_POST["email"];
			$password = $_POST["password"];

			$user_obj = new Users();

			$userdata = $user_obj->where("email", $email)->first();

			if (!empty($userdata)) {
				// user exists

				if (password_verify($password, $userdata['password'])) {
					// user details matched

					$iat = time();
					$nbf = $iat + 10;
					$exp = $iat + 43200;

					$payload = [
						"iat" => $iat,
						"nbf" => $nbf,
						"exp" => $exp,
						"expired_in" => 43200,
						"userdata" => $userdata
					];

					$token = JWT::encode($payload, $this->getKey(), 'HS256');

					$response = [
						"status" => 200,
						"message" => "User logged in",
						"error" => false,
						"data" => [
							"token" => $token
						]
					];
				} else {
					// password didnt match
					$response = [
						"status" => 500,
						"message" => "Password didn't match",
						"error" => true,
						"data" => []
					];
				}
			} else {
				// user doesnot exists
				$response = [
					"status" => 500,
					"message" => "Invalid details",
					"error" => true,
					"data" => []
				];
			}
		}

		return $this->respondCreated($response);
	}

	public function getKey()
	{
		return getenv('TOKEN_SECRET');
	}

	// GET
	public function userProfile()
	{
		$auth = $this->request->header("Authorization");

		try {

			if (isset($auth)) {

				$token = $auth->getValue();

				$decoded_data = JWT::decode($token, new Key($this->getKey(), 'HS256'));


				$response = [
					"status" => 200,
					"message" => "User profile data",
					"error" => false,
					"data" => [
						"user" => $decoded_data,
						"id" => $decoded_data->userdata->customer_id
					]
				];
			} else {

				$response = [
					"status" => 500,
					"message" => "User must be login",
					"error" => true,
					"data" => []
				];
			}
		} catch (Exception $ex) {

			$response = [
				"status" => 500,
				"message" => $ex->getMessage(),
				"error" => true,
				"data" => []
			];
		}

		return $this->respondCreated($response);
	}
}
