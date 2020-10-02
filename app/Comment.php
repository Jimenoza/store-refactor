<?php

namespace tiendaVirtual;

use Illuminate\Database\Eloquent\Model;
use DB;

class Comment extends Model
{
    protected $table = 'califications';
    protected $fillable = [
        'comment',
        'calification',
        'product_id',
        'user_id'
    ];
    public $timestamps = false;

    public static function getReplies($comment){
        return Reply::where('idCalificacion',$comment)->get();
    	// return Reply::getReplies($comment);
    }
}
