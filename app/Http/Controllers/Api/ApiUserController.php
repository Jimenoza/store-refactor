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
            if($user->admin){
                return redirect('admin/product/index');
            }
            else {
                return redirect()->back();
            }
        }
        else{
            $request->session()->put('flash_message_error', '¡El correo o la contraseña son inválidos!');
            $request->session()->put('modal', '#popupLogin');
            return redirect()->back();
        }
    }
}
