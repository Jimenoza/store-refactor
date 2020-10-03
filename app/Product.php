<?php
namespace tiendaVirtual;
use Illuminate\Database\Eloquent\Model;
use DB;
class Product extends Model
{
    protected $table = 'products';
    public $timestamps = false;

    protected $fillable = [
    'name',
    'description',
    'image',
    'price',
    'stock',
    'available',
    'califications',
    'average',
    'category_id'];

    public static function search($filtro,$catID=NULL){
        if(!$catID){
            $response = DB::select('select * from producto where nombre LIKE "%'.$filtro.'%" and estado = 1;');
        }
        else{
            $response = DB::select('select * from products where name LIKE "%'.$filtro.'%" and available = 1 and category_id = '.$catID.';');
        }
        return $response;
        // return DB::select("call busqueda_producto('".$filtro."',".$catID.");");
    }

}
