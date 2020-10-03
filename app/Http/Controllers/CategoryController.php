<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use tiendaVirtual\Category;
use Session;
use Auth;

class CategoryController extends Controller
{
  public function indexCategory() {
    // Obtiene una colección con los datos de la tabla categoria
    $categories = Category::get();
    /* La colección se transforma a JSON seguidamente el JSON y convierte los strings en variables
    de PHP */
  	$categories = json_decode(json_encode($categories));
  	return view('admin.categoria.indexCategoria')->with(compact('categories'));
  }

  public function addCategory(Request $request) {
    /*Agrega una nueva categoría al sistema*/
  	if($request->isMethod('post')) {
  		$data = $request->all();
      // Agregar categoría a la base de datos
  		$category = new Category; //Crea un objeto categoría
  		$category->name = $data['nombre'];
  		$category->description = $data['descripcion'];
  		$category->enable = '1';
  		$category->save();//Lo registra en la base de datos
  		return redirect('/admin/category/index')->with('flash_message_success', 'La categoría fue añadida correctamente.');
  	}
  	return view('admin.categoria.agregarCategoria');
  }

  public function editCategory(Request $request, $id = null) {
    /*Obtiene una categoría y despliega en pantalla sus datos para editarlos*/
  	if ($request->isMethod('post')) {//Si se han hecho cambios
  		$data = $request->all();
      // Actualizar categoría en la base de datos
  		Category::where(['id'=>$id])->update(['name'=>$data['nombre'], 'description'=>$data['descripcion'], 'enable'=>$data['condicion']]);//actualiza los datos
  		return redirect('/admin/category/index')->with('flash_message_success', '¡La categoría fue actualizada correctamente!');
  	}
    // Obtiene la información relacionada con la categoria
  	$detallesCategoria = Category::where(['id'=>$id])->first();//Obtiene los datos de la base
  	return view('admin.categoria.editarCategoria')->with(compact('detallesCategoria'));
  }

  public function deleteCategory($id = null) {
    /*Elimina la categoría de la base (cambia el estado y no se despliega)*/
    // Verifica si el id es diferente de nulo
  	if (!empty($id)) {
  		Category::where(['id'=>$id])->update(['enable'=>'0']);
  		return redirect()->back()->with('flash_message_success', '¡La condición de la Categoría fue actualizada correctamente!');
  	}
  }
}
