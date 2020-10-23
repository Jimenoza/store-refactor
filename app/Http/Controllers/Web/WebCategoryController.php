<?php

namespace tiendaVirtual\Http\Controllers\Web;

use Illuminate\Http\Request;
use tiendaVirtual\Http\Controllers\Controller;
use tiendaVirtual\Http\Controllers\Common\CategoryController;
use tiendaVirtual\Http\Requests\Web\WebCategoriaFormRequest;
use tiendaVirtual\Category;

class WebCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = CategoryController::index();
        return view('admin.categoria.indexCategoria')->with(compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categoria.agregarCategoria');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WebCategoriaFormRequest $request)
    {
        $data = $request->validated();
        $body = [
            'name' => $data['nombre'],
            'description' => $data['descripcion']
        ];
        $response = CategoryController::addCategory($body);
        return redirect('/admin/category/index')->with('flash_message_success', 'La categoría fue añadida correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Obtiene la información relacionada con la categoria
  	    $detallesCategoria = CategoryController::getCategory($id);//Obtiene los datos de la base
  	    return view('admin.categoria.editarCategoria')->with(compact('detallesCategoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WebCategoriaFormRequest $request, $id)
    {
        $data = $request->validated();
        $body = [
            'name' => $data['nombre'],
            'description' => $data['descripcion'],
            'enable' => $data['condicion']
        ];
        $response = CategoryController::update($body,$id);
        return redirect('/admin/category/index')->with('flash_message_success', '¡La categoría fue actualizada correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = CategoryController::deleteCategory($id);
        return redirect()->back()->with('flash_message_success', '¡La condición de la Categoría fue actualizada correctamente!');
    }
}
