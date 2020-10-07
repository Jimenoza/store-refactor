<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use tiendaVirtual\Http\Requests\LoginFormRequest;
use tiendaVirtual\Http\Requests\RegisterFormRequest;
use tiendaVirtual\Http\Requests\UpdatePasswordFormRequest;
use Session;
use tiendaVirtual\User;
use tiendaVirtual\Cart;
use DB;

class AdminController extends Controller
{
  public function loginAdmin(LoginFormRequest $request) {
    /*Inicia sesión en la página de administrador, sino, retorna a la página de login indicando
    que no puede*/
    if($request->isMethod('post')){
  		$data = $request->validated(); //Son las etiquetas del html, obitene lo que están en ellos
  		if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'admin'=>'1'])){
        //User::loginUser($datos['email']);//Hace el login, llamando a la clase User
  			return redirect('admin/product/index');
  		} else {
        // Volver a página principal con mensaje de error
  			return redirect('/admin')->with('flash_message_error', 'Usuario o Contraseña incorrectos.');
  		}
  	}
  	return view('admin.login');
  }

  public function index() {
    // Lleva a la página de inicio de administrador
      return view('admin.inicio');
  }

  public function dashboard() {
    //Lleva a la página de del dashboard del administrador
      self::checkIsAdminUser();//Verifica que el usuario logueado sea administrador
      return view('admin.dashboard');

  }
  public function logout() {
    /*Cierra la sesión actual, en este caso, de la sesión del administrador*/
    Auth::logout();
    return redirect('/cliente')->with('flash_message_success', '¡Cierre de sesión completo!');
  }
  public function configurations() {
    /*Lleva a la página de las configuariones*/
      self::checkIsAdminUser();//Verifica que el usuario logueado sea administrador
      return view('admin.configuraciones');
  }

  public function checkPassword(Request $request) {
    /*Compara la contraseña ingresada con la que está registrada en la base de datos
    Retorna true si coinciden, false caso contrario*/
      $data = $request->all();
      $password = $dara['ctr_actual']; // Contiene la contraseña ingresada por el usuario
      $checkPass = User::where(['admin'=>'1'])->first(); //Obtiene la información del usuario actual
      // Se verifica que la contraseña ingresada coincida con la contraseña almacenda en la BD por medio del hash
      if (Hash::check($contrasenaActual, $checkPass->contrasena)) {
          echo "true"; die;
      } else {
          echo "false"; die;
      }
  }

  public function create(){
    return view('admin.crearAdmin');
  }

  public function store(RegisterFormRequest $request) {
    /*Crea un nuevo usuario administrador, el usuario logueado debe ser administrador y
    el nuevo usuario no debe estar previamente registrado en el sistema*/
    $data = $request->validated();
    // Obtener cantidad de usuarios con el mismo correo
    $userCount = User::where('email', $data['userEmail'])->count();
    if ($userCount > 0) {
      // El correo ingresado ya existe
      return redirect('/admin/new/admin')->with('flash_message_error', '¡El correo introducido ya existe!');
    } else {
      // Creación de nuevo usuario administrador
      $user = new User;
      $user->name = $data['userName'];
      $user->email = $data['userEmail'];
      $user->password = bcrypt($data['password']);
      $user->admin = '1';
      $user->save();
      return redirect('/admin/new/admin')->with('flash_message_success', '¡Se ha creado un nuevo Administrador!');
    }
  }

  public function updatePassword (UpdatePasswordFormRequest $request) {
    /*Permite cambiar la contraseña del usuario administrador logueado*/
    $data = $request->all();
    // Obtiene los datos del usuario actual
    $checkPass = User::where(['email' => Auth::user()->email])->first();
    $currentPass = $data['currentPassword'];
    if (Hash::check($currentPass, $checkPass->password)) {
        // Crea encriptación de contraseña ingresada
        $password = bcrypt($data['newPassword']);
        // Actualización de la contraseña en la base de datos
        User::where('id','1')->update(['password' => $password]);
        return redirect('/admin/configs')->with('flash_message_success', 'Su contraseña ha sido actualizada.');
    } else {
        return redirect('/admin/configs')->with('flash_message_error', 'Contraseña actual incorrecta.');
    }
  }

  private function checkIsAdminUser(){
      /*Verifica que haya alguien logueado y si hay alguien, verifica que sea admin*/
      $user = Auth::user();
      if(!$user->admin){
          return redirect('/admin')->with('flash_message_error', 'Error acceso denegado.');
      }
  }

  public static function avisarErrorAdmin(){
    $user = Auth::user();//Busca si hay un usuario logeado en el sistema, sino, user tiene el valor 'NULL'
    $carritoLen = Cart::getCartSize();
    $total = Cart::totalPrice();
    return view('cliente.error',['usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total]);
  }
}
