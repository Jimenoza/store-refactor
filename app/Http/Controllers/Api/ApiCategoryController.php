<?php

namespace tiendaVirtual\Http\Controllers\Api;

use Illuminate\Http\Request;
use tiendaVirtual\Http\Controllers\Controller;
use tiendaVirtual\Http\Controllers\Common\CategoryController;
use tiendaVirtual\Http\Requests\Api\ApiCategoryFormRequest;

class ApiCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = CategoryController::index();
        return response()->json(['data' => $categories,'error' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApiCategoryFormRequest $request)
    {
        $data = $request->validated();
        $body = [
            'name' => $data['name'],
            'description' => $data['description']
        ];
        $response = CategoryController::addCategory($body);
        return response()->json(['data' => $response,'error' => null]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(['data' => CategoryController::getCategory($id),'error' => null]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApiCategoryFormRequest $request, $id)
    {
        $data = $request->validated();
        $body = [
            'name' => $data['name'],
            'description' => $data['description'],
        ];
        if(array_key_exists('condition',$data)){
            $body['enable'] = $data['condition'];
        }
        $response = CategoryController::update($body,$id);
        return response()->json(['data' => $response,'error' => null]);
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
}
