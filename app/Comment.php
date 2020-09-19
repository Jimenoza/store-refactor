<?php

namespace tiendaVirtual;

use Illuminate\Database\Eloquent\Model;
use DB;

class Comment extends Model
{
    private $id;
    private $texto;
    private $calificacion;
    private $producto;
    private $usuario;

    public function __construct($text,$calification,$product,$user){
        $this->texto = $text;
        $this->calificacion = $calification;
        $this->producto = $product;
        $this->usuario = $user;
    }

    public function setID($id){$this->id = $id;}

    public function getText(){return $this->texto;}
    public function getCalification(){return $this->calificacion;}
    public function getProducto(){return $this->producto;}
    public function getUser(){return $this->usuario;}
    public function getID(){return $this->id;}

    public static function getComments($producto){
    	$comments = array();
    	$response = DB::select("call getComentarios(".$producto.");");
    	foreach ($response as $comentario) {
    		$comment = new Comment($comentario->comentario,$comentario->calificacion,
    			$comentario->idProducto,$comentario->name);
    		$comment->setID($comentario->id);//cambiar por id
    		$comments[] = $comment;
    	}
    	return $comments;
    }

    public function saveComment(){
    	DB::insert("call nuevoComentario('".$this->texto."',".$this->calificacion.",".$this->producto.",'".$this->usuario."');");
    }

    public function getReplies(){
    	return Reply::getReplies($this->id);
    }
}
