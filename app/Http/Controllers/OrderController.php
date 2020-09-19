<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use tiendaVirtual\User;
use DB;
use Session;
use Auth;

class OrderController extends Controller
{
    public function __construct(){

    }

    public function getOrders(){
        /*Despliega las órdenes por usuario, si hay alguien logueado*/
    	//if(User::hayUsuarioLogueado()){//Pregunta que haya algún usuario logueado
            try{
    		  $categories = DB::select("call getCategorias()"); //Obtiene las categorías y revisa que haya conexión con la vase de datos
            }catch (\Exception $e){
                return handleError($e);
            }
	    	$user = Auth::user();//Obtiene el usuario logueado
	    	$cartSize = self::cartSize();
	        $orders = self::getUserOrders();
	      	$total = Session::get('total');
	    	return view('cliente.ordenes',['categorias' => $categories,'usuario'=>$user,'carritoLen' => $cartSize,'total' => $total,'ordenes' => $orders]);
    	/*}else{
    		return redirect('/login/page');
    	}*/
    }

    private function getUserOrders(){
        /*obtiene las órdenes del usuario logueado*/
        $correo = Auth::user()->email;
        return DB::select("call ordenesPorUsuario('".$correo."');");
    }

    private function cartSize(){
        if(Session::has('carrito')){
            return count(Session::get('carrito'));
        }
        else{
            return 0;
        }
    }

    public function getOrder($id){
        try{
            $products = DB::select("call productosPorOrden(".$id.");");
            return view('cliente.popups.orden',['productos' => $products]);
        }catch (\Exception $e){
            return handleError($e);
        }
    }

}
