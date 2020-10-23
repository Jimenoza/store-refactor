<?php

namespace tiendaVirtual\Http\Controllers\Common;

use Illuminate\Http\Request;
use tiendaVirtual\Category;
use Session;
use Auth;

class CategoryController
{
  public static function index() {
    // Obtiene una colección con los datos de la tabla categoria
    $categories = Category::get();
    /* La colección se transforma a JSON seguidamente el JSON y convierte los strings en variables
    de PHP */
	$categories = json_decode(json_encode($categories));
	return $categories;
  }

  public static function getCategory($id){
	  return Category::findOrFail($id);
  }

  public static function addCategory($data) {
    /*Agrega una nueva categoría al sistema*/
	// Agregar categoría a la base de datos
	$category = new Category; //Crea un objeto categoría
	$category->name = $data['name'];
	$category->description = $data['description'];
	$category->enable = '1';
	return $category->save();//Lo registra en la base de datos
  }

  public static function update($data, $id = null) {
    /*Obtiene una categoría y despliega en pantalla sus datos para editarlos*/
	// Actualizar categoría en la base de datos
	$category = Category::findOrFail($id);
	$category->name = $data['name'];
	$category->description = $data['description'];
	if(array_key_exists('enable',$data)){
		$category->enable = $data['enable'];
	}
	return $category->save();
	//Category::where(['id'=>$id])->update(['name'=>, 'description'=>, 'enable'=>]);//actualiza los datos
  }

  public static function deleteCategory($id = null) {
    /*Elimina la categoría de la base (cambia el estado y no se despliega)*/
    // Verifica si el id es diferente de nulo
  	if (!empty($id)) {
		$category = Category::findOrFail($id);
		$category->enable = 0;
		return $category->save();
  		// Category::where(['id'=>$id])->update(['enable'=>'0']);
  	}
  }
}
