<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    private $userModel;

    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    public function register(Request $request){
        
    }
    public function login(Request $request){

    }
    public function logout(Request $request){

    }


}
