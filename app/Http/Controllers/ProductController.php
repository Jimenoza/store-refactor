<?php
namespace tiendaVirtual\Http\Controllers;
use tiendaVirtual\Http\Requests\ProductSearchRequest;
use tiendaVirtual\Http\Requests\CommentProductRequest;
use tiendaVirtual\Http\Requests\ReplyCommentRequest;
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

class ProductController
{
  public static function index() {
    /*Verifica que haya alguien logueado como admin y despliega todos los productos de la
    base de datos*/
    $products = Product::all();
    return $products;
  }
  public static function newProduct($data){
    // Agregar el producto a la Base
    $product = new Product;
    $product->name = $data['name'];
    $product->description = $data['description'];
    $product->image = $data['image'];
    $product->price = $data['price'];
    $product->category_id = $data['category_id'];
    $product->stock = $data['stock'];
    return $product->save();
  }

  public static function editProduct($data, $id) {
    /*Busca el producto en la base de datos para desplegar en la interfaz y que se pueda
    editar*/
    $productDetail = Product::find($id);
    $productDetail->name = $data['nombre'];
    $productDetail->description = $data['descripcion'];
    $productDetail->image = $image;
    $productDetail->price = $data['precio'];
    $productDetail->category_id = $data['categorias'];
    $productDetail->stock = $data['disponibles'];
    return $productDetail->save();
  }

  public static function editProductPage($id){
    
  }

  public static function removeProduct($id) {
    $product = Product::find($id);
    $product->available = 0;
    return $product->save();
  }

  public static function enableProduct($id){
    $product = Product::find($id);
    $product->available = 1;
    return $product->save();
    // DB::update("update producto set estado = 1 where idProducto = ".$id);
  }


  public static function search($data){
    // $data = $request->all();
    /*Busca productos por una frase ingresada por el usuario*/
    $products = Product::where('name','like','%'.$$data['filter'].'%');
    if($data['category']){
      $products = $products->where('category_id','=',$data['category']);
    }
    return $products->get();
  }

  public static function filter($id){
    /*Filtra y retorna productos por la categoría a la que pertenecen*/
    $products = Product::where('category_id',$id)->where('available',1)->get();
    return $products;
  }
  
  public static function productDetail($id){
    $product = Product::find($id);
    // DB::enableQueryLog();
    $comments = Comment::where('product_id',$id)->get();
    // dd(DB::getQueryLog());
    return ['product' => $product,'comments' => $comments];
  }

  public static function commentProduct($data, $id){
    $product = Product::find($id);
    $userId = Auth::user()->id;
    $comment = new Comment;
    $comment->user_id = $userId;
    $comment->comment = $data['comment'];
    $comment->calification = $data['rate'];
    $comment->product_id = $product->id;
    $commentSaved = $comment->save();
    $product->califications = ($product->califications + 1);
    $product->average = ($product->average + $data['rate'])/$product->califications;
    $productSaved = $product->save();
    // $product->rate($userEmail,$data['comentario'],$data['rate']);
    return $commentSaved && $productSaved;
  }

  public static function replyComment($data, $id){
    $userId = Auth::user()->id;
    // $reply = new Reply($data['respuestaText'],$id,$userEmail);
    $reply = new Reply;
    $reply->calification_id = $id;
    $reply->reply = $data['replyText'];
    $reply->user_id = $userId;
    return $reply->save();
  }

}