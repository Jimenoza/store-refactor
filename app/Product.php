<?php
namespace tiendaVirtual;
use Illuminate\Database\Eloquent\Model;
use DB;
class Product extends Model
{
    protected $table = 'Producto';
    protected $primaryKey = 'idProducto';
    public $timestamps = false;

    protected $fillable = [
    'nombre',
    'descripcion',
    'imagen',
    'precio',
    'categoria',
    'stock',
    'estado',
    'calificaciones',
    'promedio',
    'idCategoria'];

    public static function search($filtro,$catID=NULL){
        if(!$catID){
            $response = DB::select('select * from producto where nombre LIKE "%'.$filtro.'%" and estado = 1;');
        }
        else{
            $response = DB::select('select * from producto where nombre LIKE "%'.$filtro.'%" and estado = 1 and idCategoria = '.$catID.';');
        }
        return $response;
        // return DB::select("call busqueda_producto('".$filtro."',".$catID.");");
    }

}
