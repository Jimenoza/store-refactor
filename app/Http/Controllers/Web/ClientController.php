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
use tiendaVirtual\Http\Controllers\Controller;
use DB;
use Session;
use Auth;

class ClientController extends Controller
{
    //
    public function __construct(){

    }

    public function index(){
      /*Función principal de la página de inicio: http://localhost:8000
      Despliega los productos al usuario. Además de verificar si hay un carro creado en
      la sesión*/
      $products = Product::where('available',1)->orderBy('id', 'desc')->get();//Obtiene los productos en la base
      Cart::createCart();
    	return view('cliente.index', ['productos'=> $products]);

   	}

    public function show($id){
      return view('cliente.show', ['producto'=>Product::findOrFail($id)]);
    }
}
