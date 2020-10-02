<?php

namespace tiendaVirtual;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'total',
        'date',
        'address',
        'user_id'
    ];
    public $timestamps = false;

    public static function products($id){
        // DB::enableQueryLog();
        $products = DB::table('products')
                        ->join('products_per_order','products_per_order.product_id','=','products.product_id')
                        ->where('orden_id','=',$id)
                        ->select('name','image','price')->get();
        // dd(DB::getQueryLog());
        return $products;//DB::select('select * from users where active = ?', [1])
    }
}
