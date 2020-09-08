<?php

namespace tiendaVirtual\Http\Controllers;

use Illuminate\Http\Request;
use tiendaVirtual\Categoria;
use Session;

class CategoriaController extends Controller
{
  public function indexCategoria() {
    self::revisarUsuario();//Revisa que haya un usuario logueado y que sea administrador
    // Obtiene una colección con los datos de la tabla categoria
    $categorias = Categoria::get();
    /* La colección se transforma a JSON seguidamente el JSON y convierte los strings en variables
    de PHP */
  	$categorias = json_decode(json_encode($categorias));
  	return view('admin.categoria.indexCategoria')->with(compact('categorias'));
  }

  public function agregarCategoria(Request $request) {
    /*Agrega una nueva categoría al sistema*/
    self::revisarUsuario();//Revisa que haya un usuario logueado y que sea administrador
  	if($request->isMethod('post')) {
  		$datos = $request->all();
      // Agregar categoría a la base de datos
  		$categoria = new Categoria; //Crea un objeto categoría
  		$categoria->nombre = $datos['nombre'];
  		$categoria->descripcion = $datos['descripcion'];
  		$categoria->condicion = '1';
  		$categoria->save();//Lo registra en la base de datos
  		return redirect('/admin/indexCategoria')->with('flash_message_success', 'La categoría fue añadida correctamente.');
  	}
  	return view('admin.categoria.agregarCategoria');
  }

  public function editarCategoria(Request $request, $id = null) {
    /*Obtiene una categoría y despliega en pantalla sus datos para editarlos*/
    self::revisarUsuario();//Revisa que haya un usuario logueado y que sea administrador
  	if ($request->isMethod('post')) {//Si se han hecho cambios
  		$datos = $request->all();
      // Actualizar categoría en la base de datos
  		Categoria::where(['idCategoria'=>$id])->update(['nombre'=>$datos['nombre'], 'descripcion'=>$datos['descripcion'], 'condicion'=>$datos['condicion']]);//actualiza los datos
  		return redirect('/admin/indexCategoria')->with('flash_message_success', '¡La categoría fue actualizada correctamente!');
  	}
    // Obtiene la información relacionada con la categoria
  	$detallesCategoria = Categoria::where(['idCategoria'=>$id])->first();//Obtiene los datos de la base
  	return view('admin.categoria.editarCategoria')->with(compact('detallesCategoria'));
  }

  public function eliminarCategoria($id = null) {
    /*Elimina la categoría de la base (cambia el estado y no se despliega)*/
    self::revisarUsuario();//Revisa que haya un usuario logueado y que sea administrador
    // Verifica si el id es diferente de nulo
  	if (!empty($id)) {
  		Categoria::where(['idCategoria'=>$id])->update(['condicion'=>'0']);
  		return redirect()->back()->with('flash_message_success', '¡La condición de la Categoría fue actualizada correctamente!');
  	}
  }

  private function revisarUsuario() {
    // Se verifica que el usuario logueado sea un administrador
    $user = Session::get('frontSession','NULL');
    if( $user == 'NULL' || !$user->admin){
        return redirect('/admin')->with('flash_message_error', 'Error acceso denegado.');
    }
  }
}
