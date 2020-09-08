<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use tiendaVirtual\User;
use tiendaVirtual\Carrito;
use DB;

class AdminController extends Controller
{
  public function inicioSesion(Request $request) {
    /*Inicia sesión en la página de administrador, sino, retorna a la página de login indicando
    que no puede*/
    if($request->isMethod('post')){
  		$datos = $request->input(); //Son las etiquetas del html, obitene lo que están en ellos
  		if (Auth::attempt(['email'=>$datos['email'],'password'=>$datos['password'],'admin'=>'1'])){
        User::loguearUsuario($datos['email']);//Hace el login, llamando a la clase User
  			return redirect('admin/indexProducto');
  		} else {
        // Volver a página principal con mensaje de error
  			return redirect('/admin')->with('flash_message_error', 'Usuario o Contraseña incorrectos.');
  		}
  	}
  	return view('admin.login');
  }

  public function inicio() {
    // Lleva a la página de inicio de administrador
      return view('admin.inicio');
  }

  public function dashboard() {
    //Lleva a la página de del dashboard del administrador
      self::verificarUsuarioAdministrador();//Verifica que el usuario logueado sea administrador
      return view('admin.dashboard');

  }
  public function cierreSesion() {
    /*Cierra la sesión actual, en este caso, de la sesión del administrador*/
    User::cerrarSesion();
    return redirect('/cliente/index')->with('flash_message_success', '¡Cierre de sesión completo!');
  }
  public function configuraciones() {
    /*Lleva a la página de las configuariones*/
      self::verificarUsuarioAdministrador();//Verifica que el usuario logueado sea administrador
      return view('admin.configuraciones');
  }

  public function revisarContrasena(Request $request) {
    /*Compara la contraseña ingresada con la que está registrada en la base de datos
    Retorna true si coinciden, false caso contrario*/
      $datos = $request->all();
      $contrasena = $datos['ctr_actual']; // Contiene la contraseña ingresada por el usuario
      $chequearContrasena = User::where(['admin'=>'1'])->first(); //Obtiene la información del usuario actual
      // Se verifica que la contraseña ingresada coincida con la contraseña almacenda en la BD por medio del hash
      if (Hash::check($contrasenaActual, $chequearContrasena->contrasena)) {
          echo "true"; die;
      } else {
          echo "false"; die;
      }
  }

  public function crearUsuarioAdministrador(Request $request) {
    /*Crea un nuevo usuario administrador, el usuario logueado debe ser administrador y
    el nuevo usuario debe estar previamente registrado en el sistema*/
    self::verificarUsuarioAdministrador();//Verifica que el usuario logueado sea administrador
    if($request->isMethod('post')) {
      $datos = $request->all();
      // Obtener cantidad de usuarios con el mismo correo
      $cuentaUsuario = User::where('email', $datos['correo'])->count();
      if ($cuentaUsuario > 0) {
        // El correo ingresado ya existe
        return redirect('/admin/crearAdmin')->with('flash_message_error', '¡El correo introducido ya existe!');
      } else {
        // Creación de nuevo usuario administrador
        $usuario = new User;
        $usuario->name = $datos['nombre'];
        $usuario->email = $datos['correo'];
        $usuario->password = bcrypt($datos['ctr_nueva']);
        $usuario->admin = '1';
        $usuario->save();
        return redirect('/admin/crearAdmin')->with('flash_message_success', '¡Se ha creado un nuevo Administrador!');
        }
      }
    return view('admin.crearAdmin');
  }

  public function actualizarContrasena (Request $request) {
    /*Permite cambiar la contraseña del usuario administrador logueado*/
    self::verificarUsuarioAdministrador();//Verifica que el usuario logueado sea administrador
      if($request->isMethod('post')) {
          $datos = $request->all();
          // Obtiene los datos del usuario actual
          $chequearContrasena = User::where(['email' => Auth::user()->email])->first();
          $contrasenaActual = $datos['ctr_actual'];
          if (Hash::check($contrasenaActual, $chequearContrasena->password)) {
              // Crea encriptación de contraseña ingresada
              $contrasena = bcrypt($datos['ctr_nueva']);
              // Actualización de la contraseña en la base de datos
              User::where('id','1')->update(['password' => $contrasena]);
              return redirect('/admin/configuraciones')->with('flash_message_success', 'Su contraseña ha sido actualizada.');
          } else {
              return redirect('/admin/configuraciones')->with('flash_message_error', 'Contraseña actual incorrecta.');
          }
      }
  }

  private function verificarUsuarioAdministrador(){
      /*Verifica que haya alguien logueado y si hay alguien, verifica que sea admin*/
      $user = User::getUsuario();
      if( $user == 'NULL'|| !$user->admin){
          return redirect('/admin')->with('flash_message_error', 'Error acceso denegado.');
      }
  }

  public static function avisarErrorAdmin(){
    $user = User::getUsuario();//Busca si hay un usuario logeado en el sistema, sino, user tiene el valor 'NULL'
    $carritoLen = Carrito::getTamano();
    $total = Carrito::precioTotal();
    return view('cliente.error',['usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total]);
  }
}
