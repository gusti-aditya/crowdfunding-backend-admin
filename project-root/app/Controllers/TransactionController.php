<?php

namespace App\Controllers;
use Exception;
use CodeIgniter\RESTful\ResourceController;
use App\Models\TransactionsModel;
use App\Models\CustomersBusiness;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use function PHPUnit\Framework\isNull;

class TransactionController extends ResourceController
{

	public function getKey()
	{
		return getenv('TOKEN_SECRET');
	}

	// GET
	public function listTransaction()
	{
		try {
			// no error
			
			$auth = $this->request->header("Authorization");

			$token = $auth->getValue();

			$payload = [
				'token' => $token
			];



			$decoded_data = JWT::decode($token, new Key($this->getKey(),'HS256'));

			$user_id = $decoded_data->userdata->customer_id;


			$transaction_obj = new TransactionsModel();

			if(!isset($user_id))
			{
				$response = [
					"status" => 500,
					"message" => "User must be login",
					"error" => true,
					"data" => []
				];
			}
			else{
				$business_data = $transaction_obj->getTransactionsList($user_id);

				$response = [
					"status" => 200,
					"message" => "Transaction list",
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

	// POST
	public function createTransaction()
	{
		
		$rules = [
			"lotAmount" => "required",
			"lotValue" => "required",
			"transactionMethod" => "required",
			"transactionDest" => "required",
			"transactionType" => "required"
		];

		if (!$this->validate($rules)) {
			// errors
			$response = [
				"status" => 500,
				"message" => $this->validator->getErrors(),
				"error" => true,
				"data" => []
			];
		} else {
			// no error
			$auth = $this->request->header("Authorization");

			$token = $auth->getValue();
			$decoded_data = JWT::decode($token, new Key($this->getKey(),'HS256'));


			$user_id = $decoded_data->userdata->customer_id;

			$transaction_obj = new TransactionsModel();
			$customers_business_obj = new CustomersBusiness();

			$transId = uniqid();

			$data = [
				"transaction_id" => $transId,
				"business_id" => $this->request->getVar("businessId"),
				"customer_id" => $user_id,
				"lot_amount" => $this->request->getVar("lotAmount"),
				"lot_value" => $this->request->getVar("lotValue"),
				"subtotal" => $this->request->getVar("lotAmount")*$this->request->getVar("lotValue"),
				"status" => 'Pending',
				"transaction_method" => $this->request->getVar("transactionMethod"),
				"transaction_dest" => $this->request->getVar("transactionDest"),
				"transaction_type" => $this->request->getVar("transactionType"),
				"is_confirmed" => '0',
			];

			$data2 = [
				"business_id" => $this->request->getVar("businessId"),
				"customer_id" => $user_id,
				"purchased_lot" => $this->request->getVar("lotAmount"),
				"purchase_status" =>'Pending',
				"transaction_id" => $transId,
			];

			if ($transaction_obj->insert($data) && $customers_business_obj->insert($data2)) {
				// data has been saved
				$response = [
					"status" => 200,
					"message" => "Transaction success",
					"error" => false,
					"data" => []
				];
			} else {
				// failed to save
				$response = [
					"status" => 500,
					"message" => "Failed to create transaction",
					"error" => true,
					"data" => []
				];
			}
		}
		return $this->respondCreated($response);
	}

	public function confirmTransaction(){

		$rules = [
			"businessId" => "required",
			"transactionId" => "required"
		];

		if (!$this->validate($rules)) {
			// errors
			$response = [
				"status" => 500,
				"message" => $this->validator->getErrors(),
				"error" => true,
				"data" => []
			];
		} else {
			// no error
			$auth = $this->request->header("Authorization");

			$token = $auth->getValue();
			$decoded_data = JWT::decode($token, new Key($this->getKey(),'HS256'));


			$user_id = $decoded_data->userdata->customer_id;
			$transaction_id = $this->request->getVar("transactionId");

			$transaction_obj = new TransactionsModel();
			$customers_business_obj = new CustomersBusiness();

			$data = [
				"business_id" => $this->request->getVar("businessId"),
				"customer_id" => $user_id,
				"status" => 'Success',
				"is_confirmed" => '1',
			];

			$data2 = [
				"business_id" => $this->request->getVar("businessId"),
				"customer_id" => $user_id,
				"purchased_lot" => $this->request->getVar("lotAmount"),
				"purchase_status" =>'Success'
			];

			if ($transaction_obj->whereIn('transaction_id',$transaction_id)->set(['is_confirmed'=> '1','status' => 'Success'])->update() && $customers_business_obj->whereIn('transaction_id',$transaction_id)->set(['purchase_status' => 'Success'])->update()) {
				// data has been saved
				$response = [
					"status" => 200,
					"message" => "Confirmation success",
					"error" => false,
					"data" => []
				];
			} else {
				// failed to save
				$response = [
					"status" => 500,
					"message" => "Failed to confirm transaction",
					"error" => true,
					"data" => []
				];
			}
		}
		return $this->respondCreated($response);
	}

	public function fileUpload()
   {
      try {
         $file = $this->request->getFile('image');
         $pathName = $this->request->getPost('path');

         $profile_image = $file->getName();

         // Renaming file before upload
         $temp = explode(".", $profile_image);
         $newfilename = round(microtime(true)) . '.' . end($temp);

         if ($file->move("img/".$pathName."/", $profile_image)) {
            $response = [
               'status' => 200,
               'error' => false,
               'message' => 'File uploaded successfully',
               'data' => [
                  'file_name' => $profile_image
               ]
            ];
         } else {

            $response = [
               'status' => 500,
               'error' => true,
               'message' => 'Failed to upload image',
               'data' => []
            ];
         }
         return $this->response->setJSON($response);
      } catch (Exception $E) {
         $data = [
            'Result' => false,
            'Message'      => $E,
         ];
         return $this->response->setJSON($data);
      }
   }

   public function deleteFile(){
      try{
        $imgName = $this->request->getPost('fileNm');
        $pathName = $this->request->getPost('path');
        
        
        if(unlink("img/".$pathName."/".$imgName))
        {
         $response = [
            'Result' => true,
            'status' => 200,
            'error' => false,
            'message' => 'File deleted successfully'
         ];
        }
        else{
         $response = [
            'Result' => true,
            'status' => 500,
            'error' => true,
            'message' => 'Failed to delete image',
            'data' => []
         ];
        }
        return $this->response->setJSON($response);
      }
      catch(Exception $E)
      {
         $data = [
            'Result' => false,
            'Message'      => $E->getMessage(),
         ];
         return $this->response->setJSON($data);
      }
   }
}
