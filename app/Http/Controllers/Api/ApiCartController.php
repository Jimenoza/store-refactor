<?php

namespace tiendaVirtual\Http\Controllers\Api;

use Illuminate\Http\Request;
use tiendaVirtual\Http\Controllers\Controller;
use tiendaVirtual\Http\Controllers\Common\CartController;
use tiendaVirtual\Cart;
use tiendaVirtual\Http\Requests\Api\ApiCartRequest;

class ApiCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $respose = CartController::getCart();
        $copy = array();
        $copy['total'] = $respose['total'];
        $copy['cart'] = array();
        foreach($respose['cart'] as $prod){
            $new = clone $prod;
            $new->image = asset('images/productos/'.$new->image);
            $copy['cart'][] = $new;
        }
        return response()->json(['data' => $copy,'error' => NULL]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Cart::createCart();
        return response()->json(['data' => true,'error' => NULL],201);
    }

    public function buildCart(ApiCartRequest $request)
    {
        $data = $request->validated();
        CartController::buildCart($data['data']['cart'],$data['data']['total']);
        return response()->json(['data' => true,'error' => NULL],201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        $response = CartController::addItem($id);
        $copy = array();
        $copy['total'] = $response['total'];
        $copy['cart'] = array();
        foreach($response['cart'] as $prod){
            $new = clone $prod;
            $new->image = asset('images/productos/'.$new->image);
            $copy['cart'][] = $new;
        }
        return response()->json(['data' => $copy,'error' => NULL]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove($id)
    {
        return response()->json(['data' => CartController::removeFromCart($id),'error' => NULL]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        return response()->json(['data' => CartController::deleteCart(),'error' => NULL]);
    }
}
