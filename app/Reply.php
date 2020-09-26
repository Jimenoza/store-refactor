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
    private $id;
    private $idCalificacion;
    private $texto;
    private $usuario;

    public function __construct(){
        
    }

    public function setID($id){$this->id = $id;}

    public function getText(){return $this->texto;}
    public function getCalification(){return $this->calificacion;}
    public function getUser(){return $this->usuario;}
    public function getID(){return $this->id;}

    public static function getReplies($comentario){
    	return DB::select("call getRespuestas(".$comentario.");");
    }

    public function saveReply(){
    	DB::insert('call insertarRespuesta('.$this->idCalificacion.',"'.$this->texto.'","'.$this->usuario.'");');
    }
}
