<?php

namespace tiendaVirtual\Http\Controllers\Common;

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

class OrderController
{

    public static function getOrders(){
        /*Despliega las órdenes por usuario, si hay alguien logueado*/
        $categories = Category::where('enable',1)->get();//DB::select("call getCategorias()"); //Obtiene las categorías y revisa que haya conexión con la vase de datos
        $orders = Order::where('user_id',Auth::user()->id)->get();//self::getUserOrders();
        // dd($orders);
        return $orders;
    }

    public static function getOrder($id){
        $products = Order::products($id);//DB::select("call productosPorOrden(".$id.");");
        return $products;
    }

    public static function payOrder($data){
        /*Genera una orden en la base de datos. Obtiene todo lo necesario para ello*/
        // $data = $request->all();
        $user = Auth::user();//Siempre retorna el usuario que esté logueado
        $order = new Order;
        $order->total = Cart::totalPrice();
        $order->date = Carbon::now()->toDateTimeString();
        $order->address = $data['address'];
        $order->user_id = $user->id;
        $order->save();
        $products = Cart::getCart();// get array of products from cart
        $total = Cart::totalPrice();
        $body = [];
        foreach ($products as $product) {
            array_push($body,['order_id' => $order->id, 'product_id' => $product->id]);// to create relation of product per order
            $prod = Product::findOrFail($product->id);
            $prod->stock = ($prod->stock - 1);
            $prod->save();
        };
        DB::table('products_per_order')->insert($body);//Genera una orden con el carrito creado
        Session::forget('carrito');//Olvida el carrito que había
        Session::forget('total');
        return true;
    }

}
