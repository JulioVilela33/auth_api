<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Hash;



class AuthController extends Controller
{
    public function register(Request $request){
       
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string',
            'email'   => 'required|string|email|unique:users',
            'password'=> 'required|confirmed'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = User::create([
            'name'     => $request->get('name'),
            'email'    => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
    
        $token = JWTAuth::fromUser($user);
        
        return response()->json(compact('user','token'),201);
        
    }

   
   
    public function login(Request $request){

        $credentials = $request->only('email', 'password');

        $requer = ['email' => 'required|email', 'password' => 'required'];

        $validator = Validator::make($credentials,$requer );

        if($validator->fails()){
            return response()->json([
                
                'status'  => 'erro',
                'mensagem'=>  $validator->messages()
            ]);
        }

        try{
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json([
                    'status'  => 'erro',
                    'mensagem'=> 'Conta não encontrada!'],401);
            }

        }catch(JWTException $e){
            return response()->json([
                'status'  => 'erro',
                'mensagem'=> 'Erro, tente novamente!'],500);
        }

        return response()->json([
            'status' => 'logado!',
            'data'   => [
                'token' => $token
            ]]);

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

    public function logout(Request $request){

        $token = $request->input(‘token’);

        try {
            JWTAuth::invalidate($token);
            return response()->json([
            'status'  => 'sucesso',
            'message' => 'Deslogado']);
        } catch (JWTException $e) {

            return response()->json([
                'status'   => 'erro',
                'mesangem' => 'Não deslogado!'],500);
        }

    }
    
}
