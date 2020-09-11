<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use tiendaVirtual\Categoria;
use tiendaVirtual\Carrito;
use tiendaVirtual\User;
use tiendaVirtual\Producto;


class CarritoController extends Controller
{
    //
    public function __construct(){

    }

    public function agregarItem($id){
        /*Agrega productos al carrito*/
        try{//El try es para verificar que haya conexión con la base de datos, sino, le avisa al usuario del problema
    	   $producto = Producto::hayEnInventario($id);//Devuelve un array, de largo 1 o largo 0 con la información del producto a añadir. 0 indica que no queda en stock
        }catch (\Exception $e){
            return handleError($e);
        }
    	if(count($producto) != 0){ //Hay stock del producto
    		$carrito = Carrito::getCarrito();
    		$carrito[] = $producto[0];//Inserta el producto en el carrito,
            Carrito::guardar($carrito);//Actualiza el carrito,total,precio
    		$total = Carrito::precioTotal();
    		$total += $producto[0]->precio;
    		Carrito::actualizarPrecio($total);
    	}
    	return redirect()->back();
    }

    public function verCarrito(){
        /*Llama a los productos en el carrito para desplegar en la ventana del carrito*/
        try{
    	   $categorias = Categoria::getCategorias();//Obtiene las categorías de la base, si no hay conexión con la base, avisa del problema
        }catch (\Exception $e){
            return handleError($e);
        }
    	$user = User::getUsuario();
    	$carritoLen = Carrito::getTamano(); //Obitene la cantidad de items en el carrito
        $carrito = Carrito::getCarrito(); //Obtiene una lista (array) de los productos en el carrito
      	$total = Carrito::precioTotal();
        if(User::hayUsuarioLogueado()){
            $tarjetas = User::getTarjetas($user->email);//Obitene las tarjetas del usuario logueado
        }
        else{
            $tarjetas = array(); //Si el usuario no tiene tarjetas asociadas
        }
    	return view('cliente.cart',['categorias' => $categorias,'usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total,'carrito' => $carrito, 'tarjetas' => $tarjetas]);
    }

    public function eliminarCarrito(){
        /*Borra todo el carrito*/
    	Carrito::eliminarCarrito();
    	return redirect('cliente');
    }

    public function quitarDelCarrito($id){
        /*Borra un elemento del carrito*/
    	Carrito::quitarProducto($id);
    	return redirect()->back();
    }
    public function pagar(Request $request){
        /*Genera una orden en la base de datos. Obtiene todo lo necesario para ello*/
        if($request->isMethod('post')) {
        $datos = $request->all();
        if(!$datos['tarjetas']) {//Si no se seleccionó una tarjeta o no hay
            return Redirect::back()->with('address_error', 'Por favor seleccione una tarjeta para pagar. Si no tiene ingrese una desde Métodos de pago -> Agregar');
        }
        if($datos['direccion']) {
            $usuario = User::getUsuario();//Siempre retorna el usuario que esté logueado
            try{
                //Si no hay conexión con la base de datos avisa del problema
                Carrito::registrarCarrito($usuario->email);//Registra el carrito en la base de datos
            }catch (\Exception $e){
                return handleError($e);
            }
            $tarjeta = $datos['tarjetas'];
            $direccion = $datos['direccion'];
            Carrito::registrarCompra($tarjeta,$direccion);//Genera una orden con el carrito creado
            Session::forget('carrito');//Olvida el carrito que había
            Session::forget('total');
            return redirect('cliente')->with('success_msg', 'La orden ha sido generada, gracias por comprar con nosotros');
        } else {
          return Redirect::back()->with('address_error', 'Por favor, ingrese una dirección de envío');
        }
      }
    }

    private function lenCarrito(){
        /*Retorna el largo del carrito*/
        if(Session::has('carrito')){
            return count(Session::get('carrito'));
        }
        else{
            return 0;
        }
    }

    private function getCarrito(){
        /*Retorna la lista de productos del carrito, si no hay, se genera un nuevo carrito*/
        if(Session::has('carrito')){
            return Session::get('carrito');
        }
        else{
            Session::put('carrito',array()); //Crea un carrito de forma temporal
            Session::put('total',0);
            return array();
        }
    }
}

