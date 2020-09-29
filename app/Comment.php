<?php

namespace tiendaVirtual;

use Illuminate\Database\Eloquent\Model;
use DB;

class Comment extends Model
{
    protected $table = 'calificacion_x_producto';
    protected $primaryKey = 'id';
    protected $fillable = [
        'comentario',
        'calificacion',
        'idProducto',
        'idUsuario'
    ];
    public $timestamps = false;

    public static function getReplies($comment){
        return Reply::where('idCalificacion',$comment)->get();
    	// return Reply::getReplies($comment);
    }
}
