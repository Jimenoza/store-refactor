<?php

namespace tiendaVirtual\Http\Controllers\Api;

use Illuminate\Http\Request;
use tiendaVirtual\Http\Controllers\Controller;
use tiendaVirtual\Http\Controllers\Common\UserController;
use tiendaVirtual\Http\Requests\LoginFormRequest;
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
            return response()->json(['data' => $tokenResult,'error' => null]);
        }
        else{
            return response()->json(['data' => 'user_not_found','error' => 500]);   
        }
    }

    /**
     * Log in for users.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return response()->json(['data' => true,'error' => null]);
    }
}
