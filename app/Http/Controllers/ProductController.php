<?php
namespace tiendaVirtual\Http\Controllers;
use tiendaVirtual\Http\Requests\ProductoFormRequest;
use Illuminate\Http\Request;
use tiendaVirtual\Producto;
use tiendaVirtual\Category;
use tiendaVirtual\Cart;
use tiendaVirtual\User;
use tiendaVirtual\Respuesta;
// use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Auth;
use Session;
use DB;

class ProductController extends Controller
{
  public function index(Request $request) {
    /*Verifica que haya alguien logueado como admin y despliega todos los productos de la
    base de datos*/
    $products = Producto::getProductos();
    return view('admin.producto.indexProducto',['productos' => $products]);
  }
  public function newProduct(Request $request)
  {
    if($request->isMethod('post')) {
      $data = $request->all();
      $image = "";
      if($request->hasFile('imageInput')){ //Primero pregunta si se subió una foto
        $image = self::addImage();
      }
      // Agregar el producto a la Base
    	$product = new Producto($data['nombre'],$data['descripcion'],$image,$data['precio'],
      $data['categorias'],$data['disponibles']);
      $product->guardar();
      return redirect('/admin/indexProducto')->with('flash_message_success', 'El producto ha sido añadido correctamente.');
    }
    $categoriesList = self::getCategories();
    return view('admin.producto.agregarProducto')->with(compact('categoriesList'));
  }


  private function getCategories(){
    /*Obtiene las categorías disponibles*/
    $categories = Category::getCategories();
    /*Crea el string HTML de las categorías con respecto a un select*/
    $categoriesList = "<option value='' selected disabled>Elija una opción</option>";
    foreach ($categories as $cat) {//ciclo para desplegar las categorías
      $categoriesList .= "<option value='".$cat->idCategoria."'>".$cat->nombre."</option>";
    }
    return $categoriesList;
  }


  public function editProduct(Request $request, $id) {
    /*Busca el producto en la base de datos para desplegar en la interfaz y que se pueda
    editar*/
    $productDetail = Producto::productoPorID($id);
    if ($request->isMethod('post')) {
      $datos = $request->all();
      if($request->hasFile('imageInput')){
          $imageName = self::addImage();
      }

      $productDetail->setNombre($datos['nombre']);
      $productDetail->setDescripcion($datos['descripcion']);
      $productDetail->setImagen($imageName);
      $productDetail->setPrecio($datos['precio']);
      $productDetail->setCategoria($datos['categorias']);
      $productDetail->setStock($datos['disponibles']);
      $productDetail->actualizar();
      $productDetail = null;
      return redirect('/admin/indexProducto')->with('flash_message_success', '¡El Producto ha sido actualizado correctamente!');
    }
    if ($productDetail == NULL) {
      return redirect()->back()->with('flash_message_error', 'La URL especificada no existe');
    }
    $productCategory = $productDetail->getCategoria();
    $categories = Category::getCategories();
    $categoriesList = "<option value='' selected disabled>Elija una opción</option>";
    foreach ($categories as $cat) {
        $selected = "";
        error_log($cat->idCategoria." == ".$productCategory);
        if ($cat->idCategoria == $productCategory) {
            $selected = "selected";
        }
        $categoriesList .= "<option value='".$cat->idCategoria."' ".$selected." >".$cat->nombre."</option>";
    }
    return view('admin.producto.editarProducto')->with(compact('detallesProducto','listadoCategorias'));
  }

  private function addImage(){
    $image = \Input::file('imageInput');
    $image->move(public_path().'/images/productos/',$image->getClientOriginalName());//guarda la imagen en: \qa-grupo7\Tienda_Virtual\storage\app\images
    return $image->getClientOriginalName();
  }

  public function removeProduct($id) {
    if (!empty($id)) {
      $product = Producto::productoPorID($id);
      $product->eliminar();
      return redirect()->back()->with('flash_message_success', '¡El producto ha sido inhabilitado correctamente!');
    }
  }

  public function enableProduct($id){
    DB::update("update producto set estado = 1 where idProducto = ".$id);
    return redirect()->back()->with('flash_message_success', '¡Producto habilitado para la compra!');
  }


  public function search(Request $request){
    /*Busca productos por una frase ingresada por el usuario*/
    try{
      $filter = trim($request->get('buscador'));//Obtiene lo que el usuario ingresó
      $catFilter = trim($request->get('catFiltro'));
      $products = Producto::buscar($filter,$catFilter);
      $categories = Category::getCategories();
    }catch (\Exception $e){
      return handleError($e);
    }
    $user = Auth::user();
    $cartSize = Cart::getCartSize();
    $total = Cart::totalPrice();
    $pages = self::paginate($products,$filter);
    return view('cliente.results', ['productos'=> $pages,'categorias' => $categories,'filtro' =>$filter,'usuario'=>$user,'carritoLen' => $cartSize,'total' => $total]);
  }

  public function filter($id){
    /*Filtra y retorna productos por la categoría a la que pertenecen*/
    try{
      $categories = Category::getCategories();
    }catch (\Exception $e){
      return handleError($e);
    }
    $user = Auth::user();
    $cartSize = Cart::getCartSize();
    $total = Session::get('total');
    $catName = Cart::totalPrice();
    foreach ($categories as $cat) {
      if($cat->idCategoria == $id){
        $catName = 'Productos de '.$cat->nombre;
        break;
      }
    }
    $products = Producto::productosPorCategoria($id);
    $pages = self::paginate($products);
    return view('cliente.categories',['productos'=> $pages,'categorias' => $categories,'nombreCat' => $catName,'usuario'=>$user,'carritoLen' => $cartSize,'total' => $total]);
  }
  
  public function productDetail($id){
    /*Retorna toda la información del producto para desplegarse en pantalla*/
    try{
      $product = Producto::productoPorId($id);
      $categories = Category::getCategories();
    }catch (\Exception $e){
      return handleError($e);
    }
    $user = Auth::user();
    $cartSize = Cart::getCartSize();
    $total = Session::get('total');
    $comments = $product->getComentarios();
    return view('cliente/product',['producto' => $product,'categorias' => $categories,'usuario'=>$user,'carritoLen' => $cartSize,'total' => $total,'comentarios' => $comments]);
  }

  public function commentProduct(Request $request, $id){
    $data = $request->all();
    $product = Producto::productoPorId($id);
    $userEmail = Auth::user()->email;
    $product->calificar($userEmail,$data['comentario'],$data['quantity_input']);
    return redirect()->back();
  }

  public function replyComment(Request $request, $id){
    $data = $request->all();
    $userEmail = Auth::user()->email;
    $reply = new Respuesta($data['respuestaText'],$id,$userEmail);
    $reply->guardar();
    return redirect()->back();
  }

  private function paginate($arreglo,$filtro = NULL){

    $perPage = 20;
    $page = \Input::get('page', 1);

    $compensador = ($page * $perPage) - $perPage;  

    $productsOnPage = array_slice($arreglo, $compensador, $perPage, true);  

    $paginator = new LengthAwarePaginator($productsOnPage, count($arreglo), $perPage, $page);

    if($filtro == NULL){
      $paginator->withPath('?');
    }else{
      $paginator->withPath('?buscador='.$filtro);
    }
    return $paginator;
  }

}