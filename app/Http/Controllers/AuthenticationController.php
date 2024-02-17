<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    private $userModel;

    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    public function register(Request $request){
        $request->validate([
           'name' => 'required|max:255|string',
           'email' => 'required|max:255|string|email|unique:users,email',
           'password' => 'required|min:8|confirmed',
        ]);

        $user = $this->userModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('auth_token')->accessToken();

        return response([
            'token' => $token
        ]);
    }
    public function login(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = $this->userModel::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            return response([
                'message' => 'The provided credentials are incorrect'
            ]);
        }

        $token = $user->createToken('auth_token')->accessToken();

        return response([
            'token' => $token
        ]);

    }
    public function logout(Request $request){
        $request->user()->token()->revoke();

        return response([
            'message' => 'Logout Successfully!'
        ]);
    }


}
