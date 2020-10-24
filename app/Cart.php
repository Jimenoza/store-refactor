<?php

namespace tiendaVirtual;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;

class Cart
{
    //

    public static function createCart(){
    	if(!Session::has('cart')){ //Pregunta si hay un carrito creado
        	Session::put('cart',array()); //Crea un carrito en la sesión
        	Session::put('total',0);
      	}
    }

    public static function getCart(){
    	self::createCart();
    	return Session::get('cart');
    }

    public static function getCartSize(){
    	if(Session::has('cart')){
            return count(Session::get('cart'));
        }
        else{
            return 0;
        }
    }

    public static function putCart($carrito){
        Session::put('cart',$carrito);
    }

    public static function totalPrice(){
    	return Session::get('total');
    }

    public static function updatePrice($precio){
        Session::put('total',$precio);
    }

    public static function deleteCart(){
        Session::forget('cart');
        Session::forget('total');
        self::createCart();
        return true;
    }

    public static function removeProduct($idProducto){
        $cart = Session::get('cart');
        $total = Session::get('total');
        $removed = false;
        for($i = 0; $i < count($cart); $i++){
            //dd($cart);
            if($cart[$i]->id == $idProducto){//Encuentra el item a quitar del carrito
                $total -= $cart[$i]->price;
                array_splice($cart,$i,1);//Lo quita de la lista(array)
                $removed = true;
                //unset($cart[$i]);
                break;
            }
        }
        if($total < 0){
            $total = 0;
        }
        Session::put('total',$total);
        Session::put('cart',$cart);
        return $removed;
    }
}
