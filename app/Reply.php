<?php

namespace tiendaVirtual;

use Illuminate\Database\Eloquent\Model;
use DB;

class Reply extends Model
{
    protected $table = 'replies';
    protected $fillable = [
        'calification_id',
        'reply',
        'user_id'
    ];
    public $timestamps = false;

}
