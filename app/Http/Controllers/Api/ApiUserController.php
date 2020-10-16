<?php

namespace tiendaVirtual\Http\Controllers\Api;

use Illuminate\Http\Request;
use tiendaVirtual\Http\Controllers\Controller;
use tiendaVirtual\Http\Controllers\Common\UserController;
use tiendaVirtual\Http\Requests\LoginFormRequest;

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
            return response()->json(['data' => $tokenResult,'error' => null]);
        }
        else{
            return response()->json(['data' => 'user_not_found','error' => 500]);   
        }
    }
}
