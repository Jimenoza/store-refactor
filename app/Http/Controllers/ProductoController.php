<?php
namespace tiendaVirtual\Http\Controllers;
use tiendaVirtual\Http\Requests\ProductoFormRequest;
use Illuminate\Http\Request;
use tiendaVirtual\Producto;
use tiendaVirtual\Categoria;
use tiendaVirtual\Carrito;
use tiendaVirtual\User;
use tiendaVirtual\Respuesta;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Auth;
use Session;
use DB;
class ProductoController extends Controller
{
  public function indexProducto(Request $request) {
    /*Verifica que haya alguien logueado como admin y despliega todos los productos de la
    base de datos*/
    self::revisarUsuario();
    $productos = Producto::getProductos();
    return view('admin.producto.indexProducto',['productos' => $productos]);
  }
  public function agregarProducto(Request $request)
  {
    self::revisarUsuario();
    if($request->isMethod('post')) {
      $datos = $request->all();
      $imagen = "";
      if($request->hasFile('imageInput')){ //Primero pregunta si se subió una foto
        $imagen = self::agregarImagen();
      }
      // Agregar el producto a la Base
    	$producto = new Producto($datos['nombre'],$datos['descripcion'],$imagen,$datos['precio'],
      $datos['categorias'],$datos['disponibles']);
      $producto->guardar();
      return redirect('/admin/indexProducto')->with('flash_message_success', 'El producto ha sido añadido correctamente.');
    }
    $listadoCategorias = self::obtenerCategorias();
    return view('admin.producto.agregarProducto')->with(compact('listadoCategorias'));
  }


  private function obtenerCategorias(){
    /*Obtiene las categorías disponibles*/
    $categorias = Categoria::getCategorias();
    /*Crea el string HTML de las categorías con respecto a un select*/
    $listadoCategorias = "<option value='' selected disabled>Elija una opción</option>";
    foreach ($categorias as $cat) {//ciclo para desplegar las categorías
      $listadoCategorias .= "<option value='".$cat->idCategoria."'>".$cat->nombre."</option>";
    }
    return $listadoCategorias;
  }


  public function editarProducto(Request $request, $id) {
    /*Busca el producto en la base de datos para desplegar en la interfaz y que se pueda
    editar*/
    self::revisarUsuario();
    $detallesProducto = Producto::productoPorID($id);
    if ($request->isMethod('post')) {
      $datos = $request->all();
      if($request->hasFile('imageInput')){
          $imagenNombre = self::agregarImagen();
      }

      $detallesProducto->setNombre($datos['nombre']);
      $detallesProducto->setDescripcion($datos['descripcion']);
      $detallesProducto->setImagen($imagenNombre);
      $detallesProducto->setPrecio($datos['precio']);
      $detallesProducto->setCategoria($datos['categorias']);
      $detallesProducto->setStock($datos['disponibles']);
      $detallesProducto->actualizar();
      $detallesProducto = null;
      return redirect('/admin/indexProducto')->with('flash_message_success', '¡El Producto ha sido actualizado correctamente!');
    }
    if ($detallesProducto == NULL) {
      return redirect()->back()->with('flash_message_error', 'La URL especificada no existe');
    }
    $categoriaProducto = $detallesProducto->getCategoria();
    $categorias = Categoria::getCategorias();
    $listadoCategorias = "<option value='' selected disabled>Elija una opción</option>";
    foreach ($categorias as $cat) {
        $selected = "";
        error_log($cat->idCategoria." == ".$categoriaProducto);
        if ($cat->idCategoria == $categoriaProducto) {
            $selected = "selected";
        }
        $listadoCategorias .= "<option value='".$cat->idCategoria."' ".$selected." >".$cat->nombre."</option>";
    }
    return view('admin.producto.editarProducto')->with(compact('detallesProducto','listadoCategorias'));
  }

  private function agregarImagen(){
    $imagen = Input::file('imageInput');
    $imagen->move(public_path().'/images/productos/',$imagen->getClientOriginalName());//guarda la imagen en: \qa-grupo7\Tienda_Virtual\storage\app\images
    return $imagen->getClientOriginalName();
  }

  public function eliminarProducto($id) {
    self::revisarUsuario();
    if (!empty($id)) {
      $producto = Producto::productoPorID($id);
      $producto->eliminar();
      $producto = null;
      return redirect()->back()->with('flash_message_success', '¡El producto ha sido inhabilitado correctamente!');
    }
  }

  public function habilitarProducto($id){
    self::revisarUsuario();
    DB::update("update producto set estado = 1 where idProducto = ".$id);
    return redirect()->back()->with('flash_message_success', '¡Producto habilitado para la compra!');
  }

  //Revisa que haya un usuario logueado y que sea admin
  private function revisarUsuario() {
    $user = Session::get('frontSession','NULL');
    if( $user == 'NULL' || !$user->admin){
        return redirect('/admin')->with('flash_message_error', 'Error acceso denegado.');
    }
  }

  public function search(Request $request){
    /*Busca productos por una frase ingresada por el usuario*/
    try{
      $filter = trim($request->get('buscador'));//Obtiene lo que el usuario ingresó
      $catFiltro = trim($request->get('catFiltro'));
      $productos = Producto::buscar($filter,$catFiltro);
      $categorias = Categoria::getCategorias();
    }catch (\Exception $e){
      return handleError($e);
    }
    $user = User::getUsuario();
    $carritoLen = Carrito::getTamano();
    $total = Carrito::precioTotal();
    $paginas = self::paginar($productos,$filter);
    return view('cliente.results', ['productos'=> $paginas,'categorias' => $categorias,'filtro' =>$filter,'usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total]);
  }

  public function filtrar($id){
    /*Filtra y retorna productos por la categoría a la que pertenecen*/
    try{
      $categorias = Categoria::getCategorias();
    }catch (\Exception $e){
      return handleError($e);
    }
    $user = User::getUsuario();
    $carritoLen = Carrito::getTamano();
    $total = Session::get('total');
    $nombreCat = Carrito::precioTotal();
    foreach ($categorias as $cat) {
      if($cat->idCategoria == $id){
        $nombreCat = 'Productos de '.$cat->nombre;
        break;
      }
    }
    $productos = Producto::productosPorCategoria($id);
    $paginas = self::paginar($productos);
    return view('cliente.categories',['productos'=> $paginas,'categorias' => $categorias,'nombreCat' => $nombreCat,'usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total]);
  }
  
  public function infoProducto($id){
    /*Retorna toda la información del producto para desplegarse en pantalla*/
    try{
      $producto = Producto::productoPorId($id);
      $categorias = Categoria::getCategorias();
    }catch (\Exception $e){
      return handleError($e);
    }
    $user = User::getUsuario();
    $carritoLen = Carrito::getTamano();
    $total = Session::get('total');
    $comentarios = $producto->getComentarios();
    return view('cliente/product',['producto' => $producto,'categorias' => $categorias,'usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total,'comentarios' => $comentarios]);
  }

  public function comentarProducto(Request $request, $id){
    if(User::hayUsuarioLogueado()){
      $datos = $request->all();
      $producto = Producto::productoPorId($id);
      $usuarioCorreo = User::getUsuario()->email;
      $producto->calificar($usuarioCorreo,$datos['comentario'],$datos['quantity_input']);
      return redirect()->back();
    }else{
      return redirect('/cliente/');
    }
  }

  public function responderComentario(Request $request, $id){
    $datos = $request->all();
    $usuarioCorreo = User::getUsuario()->email;
    $respuesta = new Respuesta($datos['respuestaText'],$id,$usuarioCorreo);
    $respuesta->guardar();
    return redirect()->back();
  }

  private function paginar($arreglo,$filtro = NULL){

    $porPagina = 20;
    $pagina = Input::get('page', 1);

    $compensador = ($pagina * $porPagina) - $porPagina;  

    $productosPagina = array_slice($arreglo, $compensador, $porPagina, true);  

    $paginador = new LengthAwarePaginator($productosPagina, count($arreglo), $porPagina, $pagina);

    if($filtro == NULL){
      $paginador->withPath('?');
    }else{
      $paginador->withPath('?buscador='.$filtro);
    }
    return $paginador;
  }

}