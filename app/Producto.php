<?php
namespace tiendaVirtual;
use Illuminate\Database\Eloquent\Model;
use DB;
class Producto extends Model
{
    protected $table = 'Producto';
    protected $primaryKey = 'idProducto';
    public $timestamps = false;

    protected $fillable = [
    'nombre',
    'descripcion',
    'imagen',
    'precio',
    'categoria',
    'stock',
    'estado'];

    private $nombre;
    private $descripcion;
    private $imagen;
    private $precio;
    private $categoria;
    private $stock;
    private $estado;
    private $id;
    private $promedio;
    private $comentarios;

    public function __construct($nombre,$descripcion,$imagen,$precio,$categoria,$stock){
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->imagen = $imagen;
        $this->precio = $precio;
        $this->categoria = $categoria;
        $this->stock = $stock;
        $this->estado = 1;
    }

    public function getNombre(){return $this->nombre;}
    public function getDescripcion(){return $this->descripcion;}
    public function getImagen(){return $this->imagen;}
    public function getPrecio(){return $this->precio;}
    public function getCategoria(){return $this->categoria;}
    public function getStock(){return $this->stock;}
    public function getEstado(){return $this->estado;}
    public function getID(){return $this->id;}
    public function getPromedio(){return $this->promedio;}
    public function getComentarios(){return $this->comentarios;}

    public function setNombre($nombre){$this->nombre = $nombre;}
    public function setDescripcion($descripcion){$this->descripcion = $descripcion;}
    public function setImagen($imagen){$this->imagen = $imagen;}
    public function setPrecio($precio){$this->precio = $precio;}
    public function setCategoria($categoria){$this->categoria = $categoria;}
    public function setStock($stock){$this->stock = $stock;}
    public function setEstado($estado){$this->estado = $estado;}
    public function setID($id){$this->id = $id;}
    public function setPromedio($prom){$this->promedio = $prom;}
    public function setComentarios($comentarios){$this->comentarios = $comentarios;}

    public static function getProductos(){
        return DB::select("call getProductos()");
    }

    public static function producosHabilitados(){
        return DB::select("call getProductosHabilitados()");
    }

    public function guardar(){
        DB::insert("call insertarProducto('".$this->nombre."','".$this->descripcion."','".$this->imagen."',".$this->precio.",".$this->stock.");");//Inserta el producto en la base de datos
        $ultimoProducto = DB::select("call ultimoProducto()")[0]->idProducto; //Obtiene el último producto en la base para sociarlo con una categoría
        DB::insert("call insertarCategoriaXProducto(".$this->categoria." ,".$ultimoProducto.");");
        $this->setID($ultimoProducto);
    }

    public static function productoPorId($id){
        $retorno = DB::select("call buscarProductoxID(".$id.")");
        $producto = null;
        if($retorno != null){
            $producto = new Producto($retorno[0]->nombre,$retorno[0]->descripcion,$retorno[0]->imagen,
                $retorno[0]->precio,$retorno[0]->Categoria_idCategoria,$retorno[0]->stock);
            $producto->setID($retorno[0]->idProducto);
            $producto->setPromedio($retorno[0]->promedio);
            $producto->cargarComentarios();
        }
        return $producto;
    }

    public function actualizar(){
        DB::update("call actualizarProducto(".$this->id.",'".$this->nombre."','".$this->descripcion."','".$this->imagen."',".$this->precio.",".$this->stock.",".$this->categoria.");");
    }

    public function eliminar(){
        DB::update('call deleteProducto('.$this->id.');');
        $this->setEstado(0);
    }

    public static function buscar($filtro,$catID){
        return DB::select("call busqueda_producto('".$filtro."',".$catID.");");
    }

    public static function productosPorCategoria($categoria){
        return DB::select("CALL productos_x_categoria(".$categoria.");");
    }

    public static function hayEnInventario($id){
        return DB::select("call verificarProducto(".$id.");");
    }

    public function calificar($usuario,$comentario,$calificacion){
        $nuevo = new Comentario($comentario,$calificacion,$this->id,$usuario);
        $nuevo->guardar();
    }

    public function cargarComentarios(){
        $this->comentarios = Comentario::getComentarios($this->id);
    }

}
