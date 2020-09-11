<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use tiendaVirtual\User;
use DB;
use Session;

class OrdenController extends Controller
{
    public function __construct(){

    }

    public function verOrdenes(){
        /*Despliega las órdenes por usuario, si hay alguien logueado*/
    	if(User::hayUsuarioLogueado()){//Pregunta que haya algún usuario logueado
            try{
    		  $categorias = DB::select("call getCategorias()"); //Obtiene las categorías y revisa que haya conexión con la vase de datos
            }catch (\Exception $e){
                return handleError($e);
            }
	    	$user = User::getUsuario();//Obtiene el usuario logueado
	    	$carritoLen = self::lenCarrito();
	        $ordenes = self::getOrdenes();
	      	$total = Session::get('total');
	    	return view('cliente.ordenes',['categorias' => $categorias,'usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total,'ordenes' => $ordenes]);
    	}else{
    		return redirect('/usuarios/inicioSesionRegistro');
    	}
    }

    private function getOrdenes(){
        /*obtiene las órdenes del usuario logueado*/
    	if(User::hayUsuarioLogueado()){
            $correo = User::getUsuario()->email;
            return DB::select("call ordenesPorUsuario('".$correo."');");
        }
        else{
            return array();
        }
    }

    private function lenCarrito(){
        if(Session::has('carrito')){
            return count(Session::get('carrito'));
        }
        else{
            return 0;
        }
    }

    public function verOrden($id){
        if(User::hayUsuarioLogueado()){
            try{
                $productos = DB::select("call productosPorOrden(".$id.");");
                return view('cliente.popups.orden',['productos' => $productos]);
            }catch (\Exception $e){
                return handleError($e);
            }
        }else{
            return redirect('/usuarios/inicioSesionRegistro');
        }
    }

}
