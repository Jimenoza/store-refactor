<?php

namespace tiendaVirtual;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Session;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function loguearUsuario($correo){
        $usuario = DB::select("call getUsuario('".$correo."');");
        Session::put('frontSession', $usuario[0]);//las sesiones se guardan en storage/framework/sessions
    }

    public static function hayUsuarioLogueado(){
        return Session::has('frontSession');
    }

    public static function getUsuario(){
        return Session::get('frontSession','NULL');
    }

    public static function esAdmin(){
        return Session::get('frontSession')->admin;
    }

    public static function cerrarSesion(){
        Session::forget('frontSession');
    }

    public static function getTarjetas($userID){
        return DB::select("call tarjetasPorUsuario('".$userID."');");
    }
}
