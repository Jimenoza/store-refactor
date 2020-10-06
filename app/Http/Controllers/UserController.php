<?php

namespace tiendaVirtual\Http\Controllers;

use tiendaVirtual\Http\Requests\LoginFormRequest;
use tiendaVirtual\Http\Requests\RegisterFormRequest;
use Illuminate\Http\Request;
use tiendaVirtual\User;
use Auth;
use Session;
use DB;

class UserController extends Controller
{
    public function loginPage() {
      return view('usuarios.registrar');
    }

    public function login(LoginFormRequest $request) {
      $data = $request->validated();
      if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])) {
        // User::loginUser($data['correo']);
        if(Auth::user()->admin){
          return redirect('admin/product/index');
        }
        else{
          return redirect()->back();
        }
      }else {
        $request->session()->put('flash_message_error', '¡El correo o la contraseña son inválidos!');
        $request->session()->put('modal', '#popupLogin');
        return redirect()->back();//->with('flash_message_error', '¡El correo o la contraseña son inválidos!');
      }
    }

    public function account() {
      return view('usuarios.cuenta');
    }

    public function register(RegisterFormRequest $request) {
      $data = $request->validated();
      $existingUser = User::where('email', $data['correoRegistrar'])->count();
      if ($existingUser > 0) {
        return redirect()->back()->with('flash_message_error', '¡El correo introducido ya existe!');
      } else {
        $user = new User;
        $user->name = $data['nombreRegistrar'];
        $user->email = $data['correoRegistrar'];
        $user->password = bcrypt($data['contrasenaRegistrar']);
        $user->admin = 0;
        if(!$user->name || !$user->email || !$user->password){
          $request->session()->put('flash_message_error', '¡Introdujo un campo no válido!');
          $request->session()->put('modal', '#popupRegister');
          return redirect()->back();//->with('flash_message_error', '¡Introdujo un campo no válido!');
        }else{
          $user->save();
        }
      }
    }

    public function checkEmail(Request $request) {
      $data = $request->all();
      $existingUser = User::where('email', $data['correo'])->count();
    }

    public function logout() {
      Auth::logout();
      // User::logout();
      return redirect('/');
    }
}
