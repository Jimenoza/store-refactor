<?php

namespace tiendaVirtual;

use Illuminate\Database\Eloquent\Model;
use DB;
class Category extends Model
{
    protected $table = 'Categoria';
    protected $primaryKey = 'idCategoria';
    public $timestamps = false;

    protected $fillable = [
      'nombre',
      'descripcion',
      'condicion'];

    public static function getCategories(){
    	return DB::select("call getCategorias()");
    }
}
