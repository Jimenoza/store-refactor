<?php

namespace tiendaVirtual;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orden';
    protected $primaryKey = 'idOrden';
    protected $fillable = [
        'total',
        'fecha',
        'direccion',
        'email'
    ];
    public $timestamps = false;

    public static function products($id){
        // DB::enableQueryLog();
        $products = DB::table('producto')
                        ->join('producto_x_orden','producto_x_orden.idProducto','=','producto.idProducto')
                        ->where('idOrden','=',$id)
                        ->select('nombre','imagen','precio')->get();
        // dd(DB::getQueryLog());
        return $products;//DB::select('select * from users where active = ?', [1])
    }
}
