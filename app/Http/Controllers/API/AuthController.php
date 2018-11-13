<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Validator;
use DB;



class AuthController extends Controller
{
    public function register(Request $request){
       
        #TODO
    }

    public function login(Request $request){

        $credentials = $request->only('email', 'password');

        $requer = ['email' => 'required|email', 'password' => 'required'];

        $validator = Validator::make($credentials,$requer );
        
        
        
        /*
        $credentials = request(['email', 'password']);

        if(!$token = auth('api')->attempt($credentials)){
            return response()->json(['error'=>'Usuario não autorizado'],401);

        }

        return response()->json([

            'token'   => $token,
            'expires' =>auth('api')->factory()->getTTL() * 60]);
        */
    
    }
    
}
