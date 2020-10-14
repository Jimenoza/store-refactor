<?php

namespace tiendaVirtual\Http\Controllers\Web;

use Illuminate\Http\Request;
use tiendaVirtual\Http\Controllers\Common\ProductController;
use tiendaVirtual\Http\Requests\Web\WebProductFormRequest;
use tiendaVirtual\Http\Requests\ProductSearchRequest;
use tiendaVirtual\Http\Requests\CommentProductRequest;
use tiendaVirtual\Http\Requests\ReplyCommentRequest;
use tiendaVirtual\Product;
use tiendaVirtual\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use tiendaVirtual\Http\Controllers\Controller;

class WebProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $response = ProductController::index();
        return view('admin.producto.indexProducto',['productos' => $response]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WebProductFormRequest $request)
    {
        $data = $request->validated();
        // if($request->hasFile('imageInput')){ //Primero pregunta si se subió una foto
        $image = self::addImage();
        //   }
        $body = [
            'name' => $data['nombre'],
            'description' => $data['descripcion'],
            'image' => $image,
            'price' => $data['precio'],
            'category_id' => $data['categorias'],
            'stock' => $data['disponibles']
        ];
        $backend = ProductController::newProduct($body);
        return redirect('/admin/product/index')->with('flash_message_success', 'El producto ha sido añadido correctamente.');
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $backend = ProductController::productDetail($id);
        return view('cliente.product',['producto' => $backend['product'],'comentarios' => $backend['comments']]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productDetail = Product::findOrFail($id);
        if (!$productDetail) {
            return redirect()->back()->with('flash_message_error', 'La URL especificada no existe');
        }
        $productCategory = $productDetail->category_id;
        $categories = Category::where('enable',1)->get();
        $categoriesList = "<option value='' selected disabled>Elija una opción</option>";
        foreach ($categories as $cat) {
            $selected = "";
            // error_log($cat->id." == ".$productCategory);
            if ($cat->id == $productCategory) {
                $selected = "selected";
            }
            $categoriesList .= "<option value='".$cat->id."' ".$selected." >".$cat->name."</option>";
        }
        return view('admin.producto.editarProducto')->with(compact('productDetail','categoriesList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WebProductFormRequest $request, $id)
    {
        $data = $request->validated();
        // if($request->hasFile('imageInput')){ //Primero pregunta si se subió una foto
        $image = self::addImage();
        //   }
        $body = [
            'name' => $data['nombre'],
            'description' => $data['descripcion'],
            'image' => $image,
            'price' => $data['precio'],
            'category_id' => $data['categorias'],
            'stock' => $data['disponibles']
        ];
        $updated = ProductController::editProduct($body,$id);
        if($updated){
            return redirect('/admin/product/index')->with('flash_message_success', '¡El Producto ha sido actualizado correctamente!');
        }
    }

    /**
     * Disable the specified product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disable($id)
    {
        if(!empty($id)){
            $disabled = ProductController::removeProduct($id);
            return redirect()->back()->with('flash_message_success', '¡El producto ha sido inhabilitado correctamente!');
        }
    }

    /**
     * Enable the specified product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function enable($id)
    {
        $enable = ProductController::enableProduct($id);
        return redirect()->back()->with('flash_message_success', '¡Producto habilitado para la compra!');
    }

    /**
     * Searches by name and/or filter by category the product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(ProductSearchRequest $request)
    {
        $data = $request->validated();
        $filter = trim($data['expression']);//Obtiene lo que el usuario ingresó
        $body = [
            'filter' => $filter
        ];
        if($data['category']){
            $category = trim($data['category']);
            $body['category'] = $category;
        }
        $products = ProductController::search($body);
        $products = self::paginate($products->toArray(),$filter);
        return view('cliente.results', ['productos'=> $products,'filtro' => $filter]);
    }

    /**
     * Filters the products by the category_id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function filter($id){
        $category = Category::fifindOrFailnd($id);
        $catName = 'Productos de '.$category->name;
        $products = ProductController::filter($id);
        $pages = self::paginate($products->toArray());
        return view('cliente.categories',['productos'=> $pages,'nombreCat' => $catName]);
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

    /**
     * Leaves a comment and a rating on the product
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function comment(CommentProductRequest $request, $id){
        $data = $request->validated();
        $body = [
            'comment' => $data['comentario'],
            'rate' => $data['rate']
        ];
        $backend = ProductController::commentProduct($body,$id);
        return redirect()->back();
    }

    /**
     * Leaves a comment and a rating on the product
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reply(ReplyCommentRequest $request, $id){
        $data = $request->validated();
        $body = [
            'replyText' => $data['replyText']
        ];
        $backend = ProductController::replyComment($body,$id);
        return redirect()->back();
    }
}
