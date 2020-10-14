<?php

namespace tiendaVirtual\Http\Controllers\Common;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use tiendaVirtual\Category;
use tiendaVirtual\Cart;
use tiendaVirtual\User;
use tiendaVirtual\Product;
use tiendaVirtual\Http\Controllers\Controller;
use Auth;


class CartController
{

    public static function addItem($id){
        /*Agrega productos al carrito*/
        $product = Product::findOrFail($id);//where('id',$id)->where('stock','>',0)->get();//Devuelve un array, de largo 1 o largo 0 con la información del producto a añadir. 0 indica que no queda en stock
    	if($product->stock != 0){ //Hay stock del producto
    		$cart = Cart::getCart();
    		$cart[] = $product;//Inserta el producto en el carrito,
            Cart::putCart($cart);//Actualiza el carrito,total,precio
    		$total = Cart::totalPrice();
    		$total += $product->price;
            Cart::updatePrice($total);
            return true;
        }
        else{
            return false;
        }
    }

    public static function getCart(){
        /*Llama a los productos en el carrito para desplegar en la ventana del carrito*/
        $cart = Cart::getCart(); //Obtiene una lista (array) de los productos en el carrito
        $total = Cart::totalPrice();
        return ['total' => $total,'cart' => $cart];
    }

    public static function deleteCart(){
        /*Borra todo el carrito*/
    	Cart::deleteCart();
    	return true;
    }

    public static function removeFromCart($id){
        /*Borra un elemento del carrito*/
        Cart::removeProduct($id);
        return true;
    }
}

