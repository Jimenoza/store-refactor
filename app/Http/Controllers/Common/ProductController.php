<?php
namespace tiendaVirtual\Http\Controllers\Common;
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
use Auth;
use Session;
use DB;

class ProductController
{
  public static function index($pagination = null) {
    /*Returns all the products from database*/
    if($pagination){
      $products = Product::paginate($pagination);
    }
    else{
      $products = Product::all();
    }
    return $products;
  }
  public static function newProduct($data){
    // Adds a new product to database
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
    /*Gets the product and edit with the values in $data*/
    $productDetail = Product::find($id);
    $productDetail->name = $data['name'];
    $productDetail->description = $data['description'];
    $productDetail->image = $data['image'];
    $productDetail->price = $data['price'];
    $productDetail->category_id = $data['category_id'];
    $productDetail->stock = $data['stock'];
    return $productDetail->save();
  }

  public static function removeProduct($id) {
    // set available to false, products are not removed
    $product = Product::find($id);
    $product->available = 0;
    return $product->save();
  }

  public static function enableProduct($id){
    // set available to true
    $product = Product::find($id);
    $product->available = 1;
    return $product->save();
  }


  public static function search($data){
    /*Searches products by a filter string and by category*/
    $products = Product::where('name','like','%'.$data['filter'].'%');
    if(array_key_exists('category',$data)){
      $products = $products->where('category_id','=',$data['category']);
    }
    return $products->get();
  }

  public static function filter($id){
    /*Gets all products from one category*/
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
    //saves a comment on the product
    $product = Product::find($id);
    $userId = Auth::user()->id;
    $comment = new Comment;
    $comment->user_id = $userId;
    $comment->comment = $data['comment'];
    $comment->calification = $data['rate'];
    $comment->product_id = $product->id;
    $commentSaved = $comment->save();
    $product->califications = ($product->califications + 1); // total of califications + 1
    $product->average = ($product->average + $data['rate'])/$product->califications; // create a new average
    $productSaved = $product->save();
    // $product->rate($userEmail,$data['comentario'],$data['rate']);
    return $commentSaved && $productSaved;
  }

  public static function replyComment($data, $id){
    // replies a comment
    $userId = Auth::user()->id;
    $reply = new Reply;
    $reply->calification_id = $id;
    $reply->reply = $data['replyText'];
    $reply->user_id = $userId;
    return $reply->save();
  }

}