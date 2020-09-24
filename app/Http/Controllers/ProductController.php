<?php
namespace tiendaVirtual\Http\Controllers;
use tiendaVirtual\Http\Requests\ProductoFormRequest;
use Illuminate\Http\Request;
use tiendaVirtual\Product;
use tiendaVirtual\Category;
use tiendaVirtual\Cart;
use tiendaVirtual\User;
use tiendaVirtual\Reply;
use tiendaVirtual\Comment;
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
    $products = Product::all();
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
      $product = new Product;
      $product->nombre = $data['nombre'];
      $product->descripcion = $data['descripcion'];
      $product->imagen = $image;
      $product->precio = $data['precio'];
      $product->idCategoria = $data['categorias'];
      $product->stock = $data['disponibles'];
      $product->save();
      return redirect('/admin/product/index')->with('flash_message_success', 'El producto ha sido añadido correctamente.');
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
    $productDetail = Product::find($id);//Product::productById($id);
    if ($request->isMethod('post')) {
      $data = $request->all();
      if($request->hasFile('imageInput')){
          $imageName = self::addImage();
      }

      // $productDetail->setName($datos['nombre']);
      // $productDetail->setDescription($datos['descripcion']);
      // $productDetail->setImage($imageName);
      // $productDetail->setPrice($datos['precio']);
      // $productDetail->setCategory($datos['categorias']);
      // $productDetail->setStock($datos['disponibles']);
      // $productDetail->updateProduct();
      $productDetail->nombre = $data['nombre'];
      $productDetail->descripcion = $data['descripcion'];
      $productDetail->imagen = $imageName;
      $productDetail->precio = $data['precio'];
      $productDetail->idCategoria = $data['categorias'];
      $productDetail->stock = $data['disponibles'];
      $productDetail->save();
      return redirect('/admin/product/index')->with('flash_message_success', '¡El Producto ha sido actualizado correctamente!');
    }
    if ($productDetail == NULL) {
      return redirect()->back()->with('flash_message_error', 'La URL especificada no existe');
    }
    $productCategory = $productDetail->getCategory();
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
    return view('admin.producto.editarProducto')->with(compact('productDetail','categoriesList'));
  }

  private function addImage(){
    $image = \Input::file('imageInput');
    $image->move(public_path().'/images/productos/',$image->getClientOriginalName());//guarda la imagen en: \qa-grupo7\Tienda_Virtual\storage\app\images
    return $image->getClientOriginalName();
  }

  public function removeProduct($id) {
    if (!empty($id)) {
      $product = Product::find($id);
      $product->estado = 0;
      $product->save();
      return redirect()->back()->with('flash_message_success', '¡El producto ha sido inhabilitado correctamente!');
    }
  }

  public function enableProduct($id){
    $product = Product::find($id);
    $product->estado = 1;
    $product->save();
    // DB::update("update producto set estado = 1 where idProducto = ".$id);
    return redirect()->back()->with('flash_message_success', '¡Producto habilitado para la compra!');
  }


  public function search(Request $request){
    /*Busca productos por una frase ingresada por el usuario*/
    try{
      $filter = trim($request->get('buscador'));//Obtiene lo que el usuario ingresó
      $catFilter = trim($request->get('catFiltro'));
      $products = Product::search($filter,$catFilter);
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
    $products = Product::productsByCategory($id);
    $pages = self::paginate($products);
    return view('cliente.categories',['productos'=> $pages,'categorias' => $categories,'nombreCat' => $catName,'usuario'=>$user,'carritoLen' => $cartSize,'total' => $total]);
  }
  
  public function productDetail($id){
    /*Retorna toda la información del producto para desplegarse en pantalla*/
    try{
      $product = Product::find($id);
      $categories = Category::getCategories();
    }catch (\Exception $e){
      return handleError($e);
    }
    $user = Auth::user();
    $cartSize = Cart::getCartSize();
    $total = Session::get('total');
    // DB::enableQueryLog();
    $comments = Comment::where('idProducto',$id)->get();
    // dd(DB::getQueryLog());
    return view('cliente.product',['producto' => $product,'categorias' => $categories,'usuario'=>$user,'carritoLen' => $cartSize,'total' => $total,'comentarios' => $comments]);
  }

  public function commentProduct(Request $request, $id){
    $data = $request->all();
    $product = Product::productById($id);
    $userEmail = Auth::user()->email;
    $product->rate($userEmail,$data['comentario'],$data['quantity_input']);
    return redirect()->back();
  }

  public function replyComment(Request $request, $id){
    $data = $request->all();
    $userEmail = Auth::user()->email;
    $reply = new Reply($data['respuestaText'],$id,$userEmail);
    $reply->saveReply();
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