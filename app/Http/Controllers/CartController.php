<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use tiendaVirtual\Categoria;
use tiendaVirtual\Cart;
use tiendaVirtual\User;
use tiendaVirtual\Producto;
use Auth;


class CartController extends Controller
{
    //
    public function __construct(){

    }

    public function addItem($id){
        /*Agrega productos al carrito*/
        try{//El try es para verificar que haya conexión con la base de datos, sino, le avisa al usuario del problema
    	   $product = Producto::hayEnInventario($id);//Devuelve un array, de largo 1 o largo 0 con la información del producto a añadir. 0 indica que no queda en stock
        }catch (\Exception $e){
            return handleError($e);
        }
    	if(count($product) != 0){ //Hay stock del producto
    		$cart = Cart::getCart();
    		$cart[] = $product[0];//Inserta el producto en el carrito,
            Cart::putCart($cart);//Actualiza el carrito,total,precio
    		$total = Cart::totalPrice();
    		$total += $product[0]->precio;
    		Cart::updatePrice($total);
    	}
    	return redirect()->back();
    }

    public function seeCart(){
        /*Llama a los productos en el carrito para desplegar en la ventana del carrito*/
        try{
    	   $categories = Categoria::getCategorias();//Obtiene las categorías de la base, si no hay conexión con la base, avisa del problema
        }catch (\Exception $e){
            return handleError($e);
        }
    	$user = Auth::user();
    	$cartSize = Cart::getCartSize(); //Obitene la cantidad de items en el carrito
        $cart = Cart::getCart(); //Obtiene una lista (array) de los productos en el carrito
        $total = Cart::totalPrice();
    	return view('cliente.cart',['categorias' => $categories,'usuario'=>$user,'carritoLen' => $cartSize,'total' => $total,'carrito' => $cart]);
    }

    public function deleteCart(){
        /*Borra todo el carrito*/
    	Cart::deleteCart();
    	return redirect('cliente');
    }

    public function removeFromCart($id){
        /*Borra un elemento del carrito*/
    	Cart::removeProduct($id);
    	return redirect()->back();
    }
    public function payCart(Request $request){
        /*Genera una orden en la base de datos. Obtiene todo lo necesario para ello*/
        if($request->isMethod('post')) {
        $data = $request->all();
        if($data['direccion']) {
            $user = Auth::user();//Siempre retorna el usuario que esté logueado
            try{
                //Si no hay conexión con la base de datos avisa del problema
                Cart::registerCart($usuario->email);//Registra el carrito en la base de datos
            }catch (\Exception $e){
                return handleError($e);
            }
            $address = $data['direccion'];
            Cart::registerPurchase($direccion);//Genera una orden con el carrito creado
            Session::forget('carrito');//Olvida el carrito que había
            Session::forget('total');
            return redirect('cliente')->with('success_msg', 'La orden ha sido generada, gracias por comprar con nosotros');
        } else {
          return Redirect::back()->with('address_error', 'Por favor, ingrese una dirección de envío');
        }
      }
    }
}

