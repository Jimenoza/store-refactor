<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use tiendaVirtual\Category;
use tiendaVirtual\Cart;
use tiendaVirtual\User;
use tiendaVirtual\Product;
use Auth;
use Carbon\Carbon;


class CartController extends Controller
{
    //
    public function __construct(){

    }

    public function addItem($id){
        /*Agrega productos al carrito*/
        try{//El try es para verificar que haya conexión con la base de datos, sino, le avisa al usuario del problema
           $product = Product::where('idProducto',$id)
                                ->where('stock','>',0)
                                ->get();//productInStock($id);//Devuelve un array, de largo 1 o largo 0 con la información del producto a añadir. 0 indica que no queda en stock
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
    	   $categories = Category::where('condicion',1)->get();//Obtiene las categorías de la base, si no hay conexión con la base, avisa del problema
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
    	return redirect('/');
    }

    public function removeFromCart($id){
        /*Borra un elemento del carrito*/
    	Cart::removeProduct($id);
    	return redirect()->back();
    }
}

