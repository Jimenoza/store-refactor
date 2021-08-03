<?php

namespace tiendaVirtual;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Session;
use DB;
use Auth;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

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

    public static function loginUser($correo){
        $usuario = DB::select("call getUsuario('".$correo."');");
        Session::put('frontSession', $usuario[0]);//las sesiones se guardan en storage/framework/sessions
    }
}
