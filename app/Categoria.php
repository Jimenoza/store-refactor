<?php

namespace tiendaVirtual;

use Illuminate\Database\Eloquent\Model;
use DB;
class Categoria extends Model
{
    protected $table = 'Categoria';
    protected $primaryKey = 'idCategoria';
    public $timestamps = false;

    protected $fillable = [
      'nombre',
      'descripcion',
      'condicion'];

    public static function getCategorias(){
    	return DB::select("call getCategorias()");
    }
}
