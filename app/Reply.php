<?php

namespace tiendaVirtual;

use Illuminate\Database\Eloquent\Model;
use DB;

class Reply extends Model
{
    protected $table = 'respuestas';
    protected $primaryKey = 'idRespuesta';
    protected $fillable = [
        'idCalificacion',
        'respuesta',
        'idUsuario'
    ];
    public $timestamps = false;

}
