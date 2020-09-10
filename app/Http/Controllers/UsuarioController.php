<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use tiendaVirtual\User;
use Auth;
use Session;
use DB;

class UsuarioController extends Controller
{
    public function inicioSesionRegistro(Request $request) {
      return view('usuarios.registrar');
    }

    public function inicioSesion(Request $request) {
      if($request->isMethod('post')) {
        $datos = $request->all();
        try{
          if(Auth::attempt(['email'=>$datos['correo'], 'password'=>$datos['contrasena']])) {
            User::loguearUsuario($datos['correo']);
            if(User::esAdmin()){
              return redirect('admin/indexProducto');
            }
            else{
              return redirect('/cliente');
            }
          }else {
            return redirect()->back()->with('flash_message_error', '¡El correo o la contraseña son inválidos!');
          }
        }catch (\Exception $e){
          return ClienteController::avisarError($e);
        }
      }
    }

    public function cuenta() {
      return view('usuarios.cuenta');
    }

    public function registrar(Request $request) {
      try{
        if($request->isMethod('post')) {
          $datos = $request->all();
          $cuentaUsuario = User::where('email', $datos['correoRegistrar'])->count();
          if ($cuentaUsuario > 0) {
            return redirect()->back()->with('flash_message_error', '¡El correo introducido ya existe!');
          } else {
            $usuario = new User;
            $usuario->name = $datos['nombreRegistrar'];
            $usuario->email = $datos['correoRegistrar'];
            $usuario->password = bcrypt($datos['contrasenaRegistrar']);
            $usuario->admin = 0;
            if(!$usuario->name || !$usuario->email || !$usuario->password){
              return redirect()->back()->with('flash_message_error', '¡Introdujo un campo no válido!');
            }else{
              $usuario->save();
            }
          }
        }
        Session::forget('frontSession');
        return redirect('/cliente');
      }catch (\Exception $e){
        return ClienteController::avisarError($e);
      }
    }

    public function chequearEmail(Request $request) {
      $datos = $request->all();
      $cuentaUsuario = User::where('email', $datos['correo'])->count();
    }

    public function cerrarSesion() {
      //Auth::logot();
      User::cerrarSesion();
      return redirect('/cliente');
    }
}
