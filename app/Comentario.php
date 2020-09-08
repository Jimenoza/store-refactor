<?php

namespace tiendaVirtual;

use Illuminate\Database\Eloquent\Model;
use DB;

class Comentario extends Model
{
    private $id;
    private $texto;
    private $calificacion;
    private $producto;
    private $usuario;

    public function __construct($texto,$calificacion,$producto,$usuario){
        $this->texto = $texto;
        $this->calificacion = $calificacion;
        $this->producto = $producto;
        $this->usuario = $usuario;
    }

    public function setID($id){$this->id = $id;}

    public function getTexto(){return $this->texto;}
    public function getCalificacion(){return $this->calificacion;}
    public function getProducto(){return $this->producto;}
    public function getUsuario(){return $this->usuario;}
    public function getID(){return $this->id;}

    public static function getComentarios($producto){
    	$comentarios = array();
    	$baseDatos = DB::select("call getComentarios(".$producto.");");
    	foreach ($baseDatos as $comentario) {
    		$comment = new Comentario($comentario->comentario,$comentario->calificacion,
    			$comentario->idProducto,$comentario->name);
    		$comment->setID($comentario->id);//cambiar por id
    		$comentarios[] = $comment;
    	}
    	return $comentarios;
    }

    public function guardar(){
    	DB::insert("call nuevoComentario('".$this->texto."',".$this->calificacion.",".$this->producto.",'".$this->usuario."');");
    }

    public function getRespuestas(){
    	return Respuesta::getRespuestas($this->id);
    }
}
