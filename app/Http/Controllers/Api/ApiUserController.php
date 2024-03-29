<?php

namespace tiendaVirtual\Http\Controllers\Api;

use Illuminate\Http\Request;
use tiendaVirtual\Http\Controllers\Controller;
use tiendaVirtual\Http\Controllers\Common\UserController;
use tiendaVirtual\Http\Requests\LoginFormRequest;
use tiendaVirtual\Http\Requests\RegisterFormRequest;
use Auth;

class ApiUserController extends Controller
{
    /**
     * Log in for users.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function login(LoginFormRequest $request)
    {
        $data = $request->validated();
        $body = ['email'=>$data['email'], 'password'=>$data['password']];
        $user = UserController::login($body);
        if($user){
            $tokenResult = $user->createToken('authToken')->plainTextToken;  
            return response()->json(['data' => ['token' => $tokenResult, 'user' => $user],'error' => null]);
        }
        else{
            return response()->json(['data' => 'user_not_found','error' => 404],404);   
        }
    }

    /**
     * Log in for users.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // $user = Auth::user();
        // $user = $request->user();
        // Auth::user()->tokens()->where('id', Auth::user()->id)->delete();
        // $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        // Auth::user()->currentAccessToken()->delete();
        // Auth::logout();
        // $user = Auth::user();
        // $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        auth()->user()->tokens()->delete();
        return response()->json(['data' => true,'error' => null]);
    }

    public function logged()
    {
        $user = Auth::user();
        return response()->json(['user' => $user,'error' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterFormRequest $request)
    {
        $data = $request->validated();
        $body = [
            'email' => $data['userEmail'],
            'name' => $data['userName'],
            'password' => $data['password']
        ];
        $response = UserController::register($body);
        if($response){
            return response()->json(['data' => true,'error' => null]);
        }
        else{
            return response()->json(['data' => 'email exists','error' => 409],409);
        }
        // $request->session()->put('flash_message_error', '¡Introdujo un campo no válido!');
        // $request->session()->put('modal', '#popupRegister');
    }

    public function dummyLogin(Request $request)
    { 
        $dummy = [
            "admin" => 0,
            "created_at" => "2020-10-24T19:09:56.000000Z",
            "email" => "h@mail.com",
            "id" => 9,
            "name" => "Mario Hugo",
            "updated_at" => "2020-10-24T19:09:56.000000Z"
        ];
        return response()->json(['data' => ['token' => '24|DUyNEiq7rEFZPOTJtcvzqPlaalZNYQiLdx6XE39m', 'user' => $dummy],'error' => null]);
    }

    public function dummyLogout(Request $request)
    {
        return response()->json(['data' => true,'error' => null]);
    }
}
