<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use tiendaVirtual\User;
use Auth;
use Session;
use DB;

class UserController extends Controller
{
    public function loginPage(Request $request) {
      return view('usuarios.registrar');
    }

    public function login(Request $request) {
      if($request->isMethod('post')) {
        $data = $request->all();
        if(Auth::attempt(['email'=>$data['correo'], 'password'=>$data['contrasena']])) {
          // User::loginUser($data['correo']);
          if(Auth::user()->admin){
            return redirect('admin/product/index');
          }
          else{
            return redirect('/');
          }
        }else {
          return redirect()->back()->with('flash_message_error', '¡El correo o la contraseña son inválidos!');
        }
      }
    }

    public function account() {
      return view('usuarios.cuenta');
    }

    public function register(Request $request) {
      if($request->isMethod('post')) {
        $data = $request->all();
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
            return redirect()->back()->with('flash_message_error', '¡Introdujo un campo no válido!');
          }else{
            $user->save();
          }
        }
      }
      Session::forget('frontSession');
      return redirect('/');
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
