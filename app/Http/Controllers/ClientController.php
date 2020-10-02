<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use tiendaVirtual\Product;
use tiendaVirtual\Category;
use tiendaVirtual\Cart;
use tiendaVirtual\User;
use Illuminate\Support\Facades\Redirect;
use tiendaVirtual\Http\Requests\ClienteFormRequest;
use Illuminate\Support\Facades\Input;
use DB;
use Session;
use Auth;

class ClientController extends Controller
{
    //
    public function __construct(){

    }

    public function index(Request $request){
      /*Función principal de la página de inicio: http://localhost:8000
      Despliega los productos al usuario. Además de verificar si hay un carro creado en
      la sesión*/
      try{
        $products = Product::where('estado',1)->orderBy('idProducto', 'desc')->get();//Obtiene los productos en la base
      }catch (\Exception $e){
        return handleError($e);
      }
      // $user = Auth::user();//Busca si hay un usuario logeado en el sistema, sino, user tiene el valor 'NULL'
      // $cartSize = Cart::getCartSize();
      Cart::createCart();
      $total = Cart::totalPrice();
    	return view('cliente.index', ['productos'=> $products,'total' => $total]);

   	}

    public function show($id){
      return view('cliente.show', ['producto'=>Product::findOrFail($id)]);
    }

    public function login(Request $request) {//Hay diferencia con el otro login
      /*Inicia sesión en la página del carrito si se hace click en proceder con pago y no hay alguien
      logueado. Despliega un pop-up con el aviso. Esta es la diferencia con inicioSesion en UserController*/
      if($request->isMethod('post')) {
        $data = $request->all();
        try{//revisar la conexión con la base de datos
          if(Auth::attempt(['email'=>$data['correo'], 'password'=>$data['contrasena']])) {
            // User::loginUser($data['correo']);
            return redirect('/cart');
          } else {
            return Redirect::back()->with('flash_message_error', '¡El correo o la contraseña son inválidos!');
          }
        }catch (\Exception $e){
          return handleError($e);
        }
      }
    }
}
