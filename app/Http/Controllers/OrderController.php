<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use tiendaVirtual\User;
use DB;
use Session;
use Auth;
use tiendaVirtual\Category;
use tiendaVirtual\Cart;
use tiendaVirtual\Order;
use Carbon\Carbon;
use tiendaVirtual\Product;

class OrderController extends Controller
{
    public function __construct(){

    }

    public function getOrders(){
        /*Despliega las órdenes por usuario, si hay alguien logueado*/
    	//if(User::hayUsuarioLogueado()){//Pregunta que haya algún usuario logueado
            try{
    		  $categories = Category::where('enable',1)->get();//DB::select("call getCategorias()"); //Obtiene las categorías y revisa que haya conexión con la vase de datos
            }catch (\Exception $e){
                return handleError($e);
            }
	    	// $user = Auth::user();//Obtiene el usuario logueado
	    	// $cartSize = Cart::getCartSize();
            $orders = Order::where('user_id',Auth::user()->id)->get();//self::getUserOrders();
            // dd($orders);
	    	return view('cliente.ordenes',['ordenes' => $orders]);
    	/*}else{
    		return redirect('/login/page');
    	}*/
    }

    public function getOrder($id){
        try{
            $products = Order::products($id);//DB::select("call productosPorOrden(".$id.");");
            return view('cliente.popups.orden',['productos' => $products]);
        }catch (\Exception $e){
            return handleError($e);
        }
    }

    public function payOrder(Request $request){
        /*Genera una orden en la base de datos. Obtiene todo lo necesario para ello*/
        if($request->isMethod('post')) {
        $data = $request->all();
        if($data['direccion']) {
            $user = Auth::user();//Siempre retorna el usuario que esté logueado
            try{
                //Si no hay conexión con la base de datos avisa del problema
                // dd(Carbon::now()->toDateTimeString());  
                $order = new Order;
                $order->total = Cart::totalPrice();
                $order->date = Carbon::now()->toDateTimeString();
                $order->address = $data['direccion'];
                $order->user_id = $user->id;
                $order->save();
                //Cart::registerCart($usuario->email);//Registra el carrito en la base de datos
            }catch (\Exception $e){
                return handleError($e);
            }
            $products = Cart::getCart();// get array of products from cart
            $total = Cart::totalPrice();
            $body = [];
            foreach ($products as $producto) {
                array_push($body,['order_id' => $order->id, 'product_id' => $producto->id]);
                $prod = Product::find($producto->id);
                $prod->stock = ($prod->stock - 1);
                $prod->save();
            };
            // DB::insert("call insertarOrden('".$dir."',".$cartID.",".$total.");");
            DB::table('products_per_order')->insert($body);
            //Cart::registerPurchase($direccion);//Genera una orden con el carrito creado
            Session::forget('carrito');//Olvida el carrito que había
            Session::forget('total');
            return redirect('/')->with('success_msg', 'La orden ha sido generada, gracias por comprar con nosotros');
        } else {
          return Redirect::back()->with('address_error', 'Por favor, ingrese una dirección de envío');
        }
      }
    }

}
