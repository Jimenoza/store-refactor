<?php

namespace tiendaVirtual\Http\Controllers\Common;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use tiendaVirtual\Http\Requests\RegisterFormRequest;
use tiendaVirtual\Http\Requests\UpdatePasswordFormRequest;
use Session;
use tiendaVirtual\User;
use tiendaVirtual\Cart;
use DB;

class AdminController
{
  public static function loginAdmin($data) {
    /*Inicia sesión en la página de administrador, sino, retorna a la página de login indicando
    que no puede*/
    if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'admin'=>'1'])){
      //User::loginUser($datos['email']);//Hace el login, llamando a la clase User
      return true;
    } else {
      // Volver a página principal con mensaje de error
      return false;
    }
  }

  public static function checkPassword($data) {
    /*Compara la contraseña ingresada con la que está registrada en la base de datos
    Retorna true si coinciden, false caso contrario*/
      $password = $data['password']; // Contiene la contraseña ingresada por el usuario
      $checkPass = User::where(['admin'=>'1'])->first(); //Obtiene la información del usuario actual
      // Se verifica que la contraseña ingresada coincida con la contraseña almacenda en la BD por medio del hash
      if (Hash::check($contrasenaActual, $checkPass->contrasena)) {
        return true;
      } else {
        return false;
      }
  }

  public static function store($data) {
    /*Crea un nuevo usuario administrador, el usuario logueado debe ser administrador y
    el nuevo usuario no debe estar previamente registrado en el sistema*/
    // Obtener cantidad de usuarios con el mismo correo
    $userCount = User::where('email', $data['email'])->count();
    if ($userCount > 0) {
      // El correo ingresado ya existe
      return false;
    } else {
      // Creación de nuevo usuario administrador
      $user = new User;
      $user->name = $data['name'];
      $user->email = $data['email'];
      $user->password = bcrypt($data['password']);
      $user->admin = '1';
      return $user->save();
    }
  }

  public static function updatePassword ($data) {
    /*Permite cambiar la contraseña del usuario administrador logueado*/
    // Obtiene los datos del usuario actual
    $checkPass = User::where(['email' => Auth::user()->email])->first();
    $currentPass = $data['currentPassword'];
    if (Hash::check($currentPass, $checkPass->password)) {
        // Crea encriptación de contraseña ingresada
        $password = bcrypt($data['newPassword']);
        // Actualización de la contraseña en la base de datos
        User::where('id','1')->update(['password' => $password]);
        return true;
    } else {
      return false;
    }
  }

  public static function avisarErrorAdmin(){
    $user = Auth::user();//Busca si hay un usuario logeado en el sistema, sino, user tiene el valor 'NULL'
    $carritoLen = Cart::getCartSize();
    $total = Cart::totalPrice();
    return view('cliente.error',['usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total]);
  }
}
