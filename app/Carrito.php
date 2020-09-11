<?php

namespace tiendaVirtual;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;

class Carrito extends Model
{
    //

    private static function crearCarrito(){
    	if(!Session::has('carrito')){ //Pregunta si hay un carrito creado
        	Session::put('carrito',array()); //Crea un carrito en la sesión
        	Session::put('total',0);
      	}
    }

    public static function getCarrito(){
    	self::crearCarrito();
    	return Session::get('carrito');
    }

    public static function getTamano(){
    	if(Session::has('carrito')){
            return count(Session::get('carrito'));
        }
        else{
            return 0;
        }
    }

    public static function guardar($carrito){
        Session::put('carrito',$carrito);
    }

    public static function precioTotal(){
    	return Session::get('total');
    }

    public static function actualizarPrecio($precio){
        Session::put('total',$precio);
    }

    public static function eliminarCarrito(){
        Session::forget('carrito');
        Session::forget('total');
    }

    public static function quitarProducto($idProducto){
        $carrito = Session::get('carrito');
        $total = Session::get('total');
        for($i = 0; $i < count($carrito); $i++){
            if($carrito[$i]->idProducto == $idProducto){//Encuentra el item a quitar del carrito
                $total -= $carrito[$i]->precio;
                unset($carrito[$i]);//Lo quita de la lista(array)
                break;
            }
        }   
        Session::put('total',$total);
        Session::put('carrito',$carrito);
    }

    public static function registrarCarrito($userID){
        DB::insert("call insertarCarrito(CURDATE(),'".$userID."');");//Crea un carrito en la base de datos
    }

    public static function getID(){
        return DB::select("call ultimoCarrito();")[0]->idCarrito;//Obtiene el idCarrito del último carrito insertado en la base
    }

    public static function registrarCompra($dir){
        $carrito = self::getCarrito();
        $carritoID = self::getID();
        $total = self::precioTotal();
        foreach ($carrito as $producto) {
            DB::insert("call insertarCarritoXProducto(".$carritoID.",".$producto->idProducto.",1);");//Inserta todos los productos en el nuevo carrito asociado al usuario
        }
        DB::insert("call insertarOrden('".$dir."',".$carritoID.",".$total.");");

    }
}
