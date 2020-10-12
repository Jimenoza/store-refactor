<?php

namespace tiendaVirtual\Http\Controllers\Web;

use Illuminate\Http\Request;
use tiendaVirtual\Http\Controllers\Controller;
use tiendaVirtual\Http\Requests\RegisterFormRequest;
use tiendaVirtual\Http\Controllers\Common\UserController;
use tiendaVirtual\Http\Requests\LoginFormRequest;
use Auth;

class WebUserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuarios.registrar');
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
            return redirect()->back();
        }
        else{
            return redirect()->back()->with('flash_message_error', '¡El correo introducido ya existe!');
        }
        // $request->session()->put('flash_message_error', '¡Introdujo un campo no válido!');
        // $request->session()->put('modal', '#popupRegister');
    }

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkEmail(Request $request)
    {
        $data = $request->all();
        $existingUser = UserController::checkEmail(['email' => $data['correo']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
