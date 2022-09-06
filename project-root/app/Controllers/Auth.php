<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\CustomerHandler;
use Exception;
use Firebase\JWT\JWT;
use App\Models\AuthModel;
use App\Models\Users;
use ResponseTrait;



class Auth extends ResourceController
{
    protected $validation = null;

    public function __construct()
    {
        $this->modelName = new AuthModel();
        $this->format = 'json';
        $this->validation = \Config\Services::validation();
    }

    public function index()
    { // GET
        $this->modelName = new Users();
        $record = $this->modelName->findAll();
        $response = $this->$record;
        return $this->respond($response, 200);
    }

}
