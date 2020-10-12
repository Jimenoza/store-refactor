<?php

namespace tiendaVirtual\Http\Controllers\Web;

use Illuminate\Http\Request;
use tiendaVirtual\Http\Controllers\Controller;
use tiendaVirtual\Http\Controllers\Common\OrderController;

class WebOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = OrderController::getOrders();
        return view('cliente.ordenes',['ordenes' => $response]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if($data['direccion']){
            $response = OrderController::payOrder(['address' => $data['direccion']]);
            return redirect('/')->with('success_msg', 'La orden ha sido generada, gracias por comprar con nosotros');
        }
        else {
            return Redirect::back()->with('address_error', 'Por favor, ingrese una dirección de envío');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = OrderController::getOrder($id);
        return view('cliente.orden',['productos' => $response]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
}
