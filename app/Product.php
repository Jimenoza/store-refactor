<?php
namespace tiendaVirtual;
use Illuminate\Database\Eloquent\Model;
use DB;
class Product extends Model
{
    protected $table = 'products';
    public $timestamps = false;

    protected $fillable = [
    'name',
    'description',
    'image',
    'price',
    'stock',
    'available',
    'califications',
    'average',
    'category_id'];

}
