<?php

namespace tiendaVirtual\Http\Controllers\Api;

use Illuminate\Http\Request;
use tiendaVirtual\Http\Controllers\Controller;
use tiendaVirtual\Http\Requests\RegisterFormRequest;
use tiendaVirtual\Http\Controllers\Common\AdminController;
use tiendaVirtual\Http\Requests\UpdatePasswordFormRequest;
use tiendaVirtual\Http\Requests\Api\ApiCheckPasswordFormRequest;

class ApiAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(RegisterFormRequest $request)
    {
        $data = $request->validated();
        $body = [
            'email' => $data['userEmail'],
            'name' => $data['userName'],
            'password' => $data['password']
        ];
        $response = AdminController::store($body);
        if($response){
            return response()->json(['data' => true,'error' => null]);
        }
        else{
            return response()->json(['data' => 'email exists','error' => 409],409);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePasswordFormRequest $request)
    {
        $data = $request->validated();
        $body = [
            'currentPassword' => $data['currentPassword'],
            'newPassword' => $data['newPassword']
        ];
        $response = AdminController::updatePassword($body);
        if($response){
            return response()->json(['data' => true,'error' => null]);
        }
        else{
            return response()->json(['data' => false,'error' => 409],409);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public static function checkPassword(ApiCheckPasswordFormRequest $request) {
        /*Compara la contraseña ingresada con la que está registrada en la base de datos
        Retorna true si coinciden, false caso contrario*/
        $data = $request->validated();
        $body = ['password' => $data['password']]; // Contiene la contraseña ingresada por el usuario
        $reponse = AdminController::checkPassword($body);
        return response()->json(['data' => $reponse,'error' => null]);
    }
}
