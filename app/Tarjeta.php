<?php

namespace tiendaVirtual;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tarjeta extends Model
{
    protected $table = 'tarjeta';
    protected $primaryKey = 'idTarjeta';
    public $timestamps = false;

 	protected $fillable = [
        'nombre_tarjeta', 'numero_tarjeta', 'ccv','fecha_expiracion','Usuario_correo'
    ];

    private $nombre_tarjeta;
    private $numero_tarjeta;
    private $ccv;
    private $fecha_expiracion;
    private $Usuario_correo;

    public function __construct($nombre_tarjeta,$numero_tarjeta,$ccv,$fecha_expiracion,$Usuario_correo){
    	$this->nombre_tarjeta = $nombre_tarjeta;
    	$this->numero_tarjeta = $numero_tarjeta;
    	$this->ccv = $ccv;
    	$this->fecha_expiracion = $fecha_expiracion;
    	$this->Usuario_correo = $Usuario_correo;
    }

    public function nuevaTarjeta(){
    	try{
    		DB::insert("call insertarTarjeta('".$this->nombre_tarjeta."',".$this->numero_tarjeta.",".$this->ccv.",".$this->fecha_expiracion.",'".$this->Usuario_correo."');");
    		return true;
    	}
    	catch(\Exception $e){
    		return false;
    	}
    }

    public static function verTarjetas($usuario){
    	return DB::select("call tarjetasPorUsuario('".$usuario."');");
    }
}
