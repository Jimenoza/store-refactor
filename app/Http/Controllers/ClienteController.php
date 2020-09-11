<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use tiendaVirtual\Producto;
use tiendaVirtual\Categoria;
use tiendaVirtual\Carrito;
use tiendaVirtual\User;
use Illuminate\Support\Facades\Redirect;
use tiendaVirtual\Http\Requests\ClienteFormRequest;
use Illuminate\Support\Facades\Input;
use DB;
use Session;
use Auth;

class ClienteController extends Controller
{
    //
    public function __construct(){

    }

    public function index(Request $request){
      /*Función principal de la página de inicio: http://localhost:8000/cliente
      Despliega los productos al usuario. Además de verificar si hay un carro creado en
      la sesión*/
      try{
        $productos = Producto::producosHabilitados();//Obtiene los productos en la base
    	  $categorias = Categoria::getCategorias(); //Si no hay conexión le avisa al usuario
      }catch (\Exception $e){
        return self::avisarError($e);
      }
      $user = User::getUsuario();//Busca si hay un usuario logeado en el sistema, sino, user tiene el valor 'NULL'
      $carritoLen = Carrito::getTamano();
      $total = Carrito::precioTotal();
    	return view('cliente.index', ['productos'=> $productos,'categorias' => $categorias,'usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total]);

   	}

    public function show($id){
      return view('cliente.show', ['producto'=>Producto::findOrFail($id)]);
    }

    public function inicioSesion(Request $request) {//Hay diferencia con el otro login
      /*Inicia sesión en la página del carrito si se hace click en proceder con pago y no hay alguien
      logueado. Despliega un pop-up con el aviso. Esta es la diferencia con inicioSesion en UsuarioController*/
      if($request->isMethod('post')) {
        $datos = $request->all();
        try{//revisar la conexión con la base de datos
          if(Auth::attempt(['email'=>$datos['correo'], 'password'=>$datos['contrasena']])) {
            User::loguearUsuario($datos['correo']);
            return redirect('/cliente/cart');
          } else {
            return Redirect::back()->with('flash_message_error', '¡El correo o la contraseña son inválidos!');
          }
        }catch (\Exception $e){
          return self::avisarError($e);
        }
      }
    }
        

    public static function avisarError($error){
      $user = User::getUsuario();//Busca si hay un usuario logeado en el sistema, sino, user tiene el valor 'NULL'
      $carritoLen = Carrito::getTamano();
      $total = Carrito::precioTotal();
      error_log($error);
      return view('cliente.error',['usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total]);
    }
}
