<?php


namespace App\Controllers;

use App\Database\Migrations\User;
use App\Models\Users;

class Home extends BaseController
{
    public function index()
    {
        $user = new Users();
        $data['users'] = $user->findAll();
        return view('welcome_message',$data);
    }
}
