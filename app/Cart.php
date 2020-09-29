<?php

namespace tiendaVirtual;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;

class Cart
{
    //

    private static function createCart(){
    	if(!Session::has('carrito')){ //Pregunta si hay un carrito creado
        	Session::put('carrito',array()); //Crea un carrito en la sesión
        	Session::put('total',0);
      	}
    }

    public static function getCart(){
    	self::createCart();
    	return Session::get('carrito');
    }

    public static function getCartSize(){
    	if(Session::has('carrito')){
            return count(Session::get('carrito'));
        }
        else{
            return 0;
        }
    }

    public static function putCart($carrito){
        Session::put('carrito',$carrito);
    }

    public static function totalPrice(){
    	return Session::get('total');
    }

    public static function updatePrice($precio){
        Session::put('total',$precio);
    }

    public static function deleteCart(){
        Session::forget('carrito');
        Session::forget('total');
    }

    public static function removeProduct($idProducto){
        $cart = Session::get('carrito');
        $total = Session::get('total');
        for($i = 0; $i < count($cart); $i++){
            //dd($cart);
            if($cart[$i]->idProducto == $idProducto){//Encuentra el item a quitar del carrito
                $total -= $cart[$i]->precio;
                array_splice($cart,$i,1);//Lo quita de la lista(array)
                //unset($cart[$i]);
                break;
            }
        }
        if($total < 0){
            $total = 0;
        }
        Session::put('total',$total);
        Session::put('carrito',$cart);
    }
}
