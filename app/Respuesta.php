<?php

namespace tiendaVirtual;

use Illuminate\Database\Eloquent\Model;
use DB;

class Respuesta extends Model
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

    public function getTexto(){return $this->texto;}
    public function getCalificacion(){return $this->calificacion;}
    public function getUsuario(){return $this->usuario;}
    public function getID(){return $this->id;}

    public static function getRespuestas($comentario){
    	return DB::select("call getRespuestas(".$comentario.");");
    }

    public function guardar(){
    	DB::insert('call insertarRespuesta('.$this->idCalificacion.',"'.$this->texto.'","'.$this->usuario.'");');
    }
}
