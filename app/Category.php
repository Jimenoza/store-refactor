<?php

namespace tiendaVirtual;

use Illuminate\Database\Eloquent\Model;
use DB;
class Category extends Model
{
    protected $table = 'categories';
    public $timestamps = false;

    protected $fillable = [
      'name',
      'description',
      'enable'];
}
