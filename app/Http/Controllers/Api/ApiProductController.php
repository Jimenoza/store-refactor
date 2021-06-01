<?php

namespace tiendaVirtual\Http\Controllers\Api;

use Illuminate\Http\Request;
use tiendaVirtual\Http\Controllers\Controller;
use tiendaVirtual\Http\Controllers\Common\ProductController;
use tiendaVirtual\Category;
use tiendaVirtual\Http\Requests\ProductSearchRequest;
use tiendaVirtual\Http\Requests\CommentProductRequest;
use tiendaVirtual\Http\Requests\ReplyCommentRequest;
use tiendaVirtual\Http\Requests\Api\ApiProductFormRequest;

class ApiProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($amount = null)
    {
        if(!empty($amount)){
            $products = ProductController::index($amount);
        }
        else{
            $products = ProductController::index(10);
        }
        foreach($products as $prod){
            $prod->image = asset('images/productos/'.$prod->image);
        }
        return response()->json(['data' => $products,'error' => NULL]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApiProductFormRequest $request)
    {
        $data = $request->validated();
        // if($request->hasFile('imageInput')){ //Primero pregunta si se subió una foto
        $image = self::addImage();
        //   }
        $body = [
            'name' => $data['name'],
            'description' => $data['description'],
            'image' => $image,
            'price' => $data['price'],
            'category_id' => $data['category'],
            'stock' => $data['stock']
        ];
        $backend = ProductController::newProduct($body);
        return response()->json(['data' => $backend,'error' => NULL],201);
    }

    private function addImage(){
        $image = \Input::file('image');
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
        $backend['product']->image = asset('images/productos/'.$backend['product']->image);
        return response()->json(['data' => $backend,'error' => NULL]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApiProductFormRequest $request, $id)
    {
        $data = $request->validated();
        // if($request->hasFile('imageInput')){ //Primero pregunta si se subió una foto
        $image = self::addImage();
        //   }
        $body = [
            'name' => $data['name'],
            'description' => $data['description'],
            'image' => $image,
            'price' => $data['price'],
            'category_id' => $data['category'],
            'stock' => $data['stock']
        ];
        $updated = ProductController::editProduct($body,$id);
        return response()->json(['data' => $updated,'error' => NULL]);
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

    /**
     * Returns all products from a category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function filter($id){
        $cat = Category::findOrFail($id); //Verifies that category exists
        $products = ProductController::filter($id);
        $products = $products->paginate(10);
        foreach($products as $prod){
            $prod->image = asset('images/productos/'.$prod->image);
            $prod->category_name = $cat->name;
        }
        return response()->json(['data' => $products,'error' => null]);
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
        if(array_key_exists('category',$data)){
            $category = trim($data['category']);
            $body['category'] = $category;
        }
        if(array_key_exists('pagination',$data)){
            $category = trim($data['pagination']);
            $body['pagination'] = $category;
        }
        $products = ProductController::search($body);
        foreach($products as $prod){
            $prod->image = asset('images/productos/'.$prod->image);
        }
        return response()->json(['data' => $products,'error' => null]);
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
            'comment' => $data['comment'],
            'rate' => $data['rate']
        ];
        $backend = ProductController::commentProduct($body,$id);
        $comments = ProductController::getComments($id);
        return response()->json(['data' => ['result' => $backend, 'comments' => $comments],'error' => null]);
    }

    /**
     * Leaves a reply in a comment
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
        return response()->json(['data' => $backend,'error' => null]);
    }

    /**
     * Returns product info without comments and replies
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function info($id){
        $backend = ProductController::productInfo($id);
        return response()->json(['data' => $backend,'error' => null]);
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
            $disabled = ProductController::disableProduct($id);
            return response()->json(['data' => $disabled,'error' => null]);
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
        if(!empty($id)){
            $enable = ProductController::enableProduct($id);
            return response()->json(['data' => $enable,'error' => null]);
        }
    }
}
