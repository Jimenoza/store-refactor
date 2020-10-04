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
        $categories = Category::where('enable',1)->get();//DB::select("call getCategorias()"); //Obtiene las categorías y revisa que haya conexión con la vase de datos
        $orders = Order::where('user_id',Auth::user()->id)->get();//self::getUserOrders();
        // dd($orders);
	    return view('cliente.ordenes',['ordenes' => $orders]);
    }

    public function getOrder($id){
        $products = Order::products($id);//DB::select("call productosPorOrden(".$id.");");
        return view('cliente.popups.orden',['productos' => $products]);
    }

    public function payOrder(Request $request){
        /*Genera una orden en la base de datos. Obtiene todo lo necesario para ello*/
        if($request->isMethod('post')) {
        $data = $request->all();
        if($data['direccion']) {
            $user = Auth::user();//Siempre retorna el usuario que esté logueado
            $order = new Order;
            $order->total = Cart::totalPrice();
            $order->date = Carbon::now()->toDateTimeString();
            $order->address = $data['direccion'];
            $order->user_id = $user->id;
            $order->save();
            $products = Cart::getCart();// get array of products from cart
            $total = Cart::totalPrice();
            $body = [];
            foreach ($products as $product) {
                array_push($body,['order_id' => $order->id, 'product_id' => $product->id]);// to create relation of product per order
                $prod = Product::find($product->id);
                $prod->stock = ($prod->stock - 1);
                $prod->save();
            };
            DB::table('products_per_order')->insert($body);//Genera una orden con el carrito creado
            Session::forget('carrito');//Olvida el carrito que había
            Session::forget('total');
            return redirect('/')->with('success_msg', 'La orden ha sido generada, gracias por comprar con nosotros');
        } else {
          return Redirect::back()->with('address_error', 'Por favor, ingrese una dirección de envío');
        }
      }
    }

}
