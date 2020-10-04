<?php
namespace tiendaVirtual\Http\Controllers;
use tiendaVirtual\Http\Requests\ProductoFormRequest;
use tiendaVirtual\Http\Requests\ProductSearchRequest;
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
      $product->name = $data['nombre'];
      $product->description = $data['descripcion'];
      $product->image = $image;
      $product->price = $data['precio'];
      $product->category_id = $data['categorias'];
      $product->stock = $data['disponibles'];
      $product->save();
      return redirect('/admin/product/index')->with('flash_message_success', 'El producto ha sido añadido correctamente.');
    }
    $categoriesList = self::getCategories();
    return view('admin.producto.agregarProducto')->with(compact('categoriesList'));
  }


  private function getCategories(){
    /*Obtiene las categorías disponibles*/
    $categories = Category::where('enable',1)->get();
    /*Crea el string HTML de las categorías con respecto a un select*/
    $categoriesList = "<option value='' selected disabled>Elija una opción</option>";
    foreach ($categories as $cat) {//ciclo para desplegar las categorías
      $categoriesList .= "<option value='".$cat->id."'>".$cat->name."</option>";
    }
    return $categoriesList;
  }


  public function editProduct(Request $request, $id) {
    /*Busca el producto en la base de datos para desplegar en la interfaz y que se pueda
    editar*/
    $productDetail = Product::find($id);
    if ($request->isMethod('post')) {
      $data = $request->all();
      if($request->hasFile('imageInput')){
          $imageName = self::addImage();
      }
      $productDetail->name = $data['nombre'];
      $productDetail->description = $data['descripcion'];
      $productDetail->image = $imageName;
      $productDetail->price = $data['precio'];
      $productDetail->category_id = $data['categorias'];
      $productDetail->stock = $data['disponibles'];
      $productDetail->save();
      return redirect('/admin/product/index')->with('flash_message_success', '¡El Producto ha sido actualizado correctamente!');
    }
    if ($productDetail == NULL) {
      return redirect()->back()->with('flash_message_error', 'La URL especificada no existe');
    }
    $productCategory = $productDetail->category_id;
    $categories = Category::where('enable',1)->get();
    $categoriesList = "<option value='' selected disabled>Elija una opción</option>";
    foreach ($categories as $cat) {
        $selected = "";
        error_log($cat->id." == ".$productCategory);
        if ($cat->id == $productCategory) {
            $selected = "selected";
        }
        $categoriesList .= "<option value='".$cat->id."' ".$selected." >".$cat->name."</option>";
    }
    return view('admin.producto.editarProducto')->with(compact('productDetail','categoriesList'));
  }

  private function addImage(){
    $image = \Input::file('imageInput');
    $extension = $image->getClientOriginalExtension();
    $name = time().'.'.$extension;
    // $photo->move(public_path().'\photos\\',$name);
    // $photo = new Photo();
    // $photo->route = 'photos/'.$name;
    // error_log($name);
    // $photo->report = $report->id;
    // $photo->save();
    $image->move(public_path().'/images/productos/',$name);//guarda la imagen en: \qa-grupo7\Tienda_Virtual\storage\app\images
    return $name;
  }

  public function removeProduct($id) {
    if (!empty($id)) {
      $product = Product::find($id);
      $product->available = 0;
      $product->save();
      return redirect()->back()->with('flash_message_success', '¡El producto ha sido inhabilitado correctamente!');
    }
  }

  public function enableProduct($id){
    $product = Product::find($id);
    $product->available = 1;
    $product->save();
    // DB::update("update producto set estado = 1 where idProducto = ".$id);
    return redirect()->back()->with('flash_message_success', '¡Producto habilitado para la compra!');
  }


  public function search(ProductSearchRequest $request){
    $data = $request->validated();
    // $data = $request->all();
    /*Busca productos por una frase ingresada por el usuario*/
    $filter = trim($data['searcher']);//Obtiene lo que el usuario ingresó
    $products = Product::where('name','like','%'.$filter.'%');
    if($data['categoryFilter']){
      $catFilter = trim($data['categoryFilter']);
      // $products = Product::search($filter,$catFilter);
      $products = $products->where('category_id','=',$catFilter);
    }

      // $categories = Category::where('condicion',1)->get();
    // dd($products->get());
    $products = self::paginate($products->get()->toArray(),$filter);
    
    return view('cliente.results', ['productos'=> $products,'filtro' =>$filter]);
  }

  public function filter($id){
    /*Filtra y retorna productos por la categoría a la que pertenecen*/
    $categories = Category::where('enable',1)->get();
    $total = Session::get('total');
    $catName = 'Productos de ';
    foreach ($categories as $cat) {
      if($cat->id == $id){
        $catName = $catName.$cat->name;
        break;
      }
    }
    $products = Product::where('category_id',$id)->get();
    $pages = self::paginate($products->toArray());
    // dd($pages);
    return view('cliente.categories',['productos'=> $pages,'nombreCat' => $catName]);
  }
  
  public function productDetail($id){
    $product = Product::find($id);
    // DB::enableQueryLog();
    $comments = Comment::where('product_id',$id)->get();
    // dd(DB::getQueryLog());
    return view('cliente.product',['producto' => $product,'comentarios' => $comments]);
  }

  public function commentProduct(Request $request, $id){
    $data = $request->all();
    $product = Product::find($id);
    $userId = Auth::user()->id;
    $comment = new Comment;
    $comment->user_id = $userId;
    $comment->comment = $data['comentario'];
    $comment->calification = $data['quantity_input'];
    $comment->product_id = $product->id;
    $comment->save();
    $product->califications = ($product->califications + 1);
    $product->average = ($product->average + $data['quantity_input'])/$product->califications;
    $product->save();
    // $product->rate($userEmail,$data['comentario'],$data['quantity_input']);
    return redirect()->back();
  }

  public function replyComment(Request $request, $id){
    $data = $request->all();
    $userId = Auth::user()->id;
    // $reply = new Reply($data['respuestaText'],$id,$userEmail);
    $reply = new Reply;
    $reply->calification_id = $id;
    $reply->reply = $data['respuestaText'];
    $reply->user_id = $userId;
    $reply->save();
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
      $paginator->withPath('?searcher='.$filtro);
    }
    return $paginator;
  }

}