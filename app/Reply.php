<?php

namespace tiendaVirtual;

use Illuminate\Database\Eloquent\Model;
use DB;

class Reply extends Model
{
    private $id;
    private $idCalificacion;
    private $texto;
    private $usuario;

    public function __construct($texto,$calificacion,$usuario){
        $this->texto = $texto;
        $this->idCalificacion = $calificacion;
        $this->usuario = $usuario;
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
