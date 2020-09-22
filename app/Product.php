<?php
namespace tiendaVirtual;
use Illuminate\Database\Eloquent\Model;
use DB;
class Product extends Model
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
    'estado',
    'calificaciones',
    'promedio',
    'idCategoria'];

    public function getName(){return $this->nombre;}
    public function getDescription(){return $this->descripcion;}
    public function getImage(){return $this->imagen;}
    public function getPrice(){return $this->precio;}
    public function getCategory(){return $this->categoria;}
    public function getStock(){return $this->stock;}
    public function getState(){return $this->estado;}
    public function getID(){return $this->id;}
    public function getAverage(){return $this->promedio;}
    public function getComments(){return $this->comentarios;}

    public function setName($nombre){$this->nombre = $nombre;}
    public function setDescription($descripcion){$this->descripcion = $descripcion;}
    public function setImage($imagen){$this->imagen = $imagen;}
    public function setPrice($precio){$this->precio = $precio;}
    public function setCategory($categoria){$this->categoria = $categoria;}
    public function setStock($stock){$this->stock = $stock;}
    public function setState($estado){$this->estado = $estado;}
    public function setID($id){$this->id = $id;}
    public function setAverage($prom){$this->promedio = $prom;}
    public function setComments($comentarios){$this->comentarios = $comentarios;}

    public static function getProducts(){
        return DB::select("call getProductos()");
    }

    public static function enabledProducts(){
        return DB::select("call getProductosHabilitados()");
    }

    public function saveProduct(){
        DB::insert("call insertarProducto('".$this->nombre."','".$this->descripcion."','".$this->imagen."',".$this->precio.",".$this->stock.");");//Inserta el producto en la base de datos
        $lastProduct = DB::select("call ultimoProducto()")[0]->idProducto; //Obtiene el último producto en la base para sociarlo con una categoría
        DB::insert("call insertarCategoriaXProducto(".$this->categoria." ,".$lastProduct.");");
        $this->setID($lastProduct);
    }

    public static function productById($id){
        $response = DB::select("call buscarProductoxID(".$id.")");
        $product = null;
        if($response != null){
            $product = new Product($response[0]->nombre,$response[0]->descripcion,$response[0]->imagen,
                $response[0]->precio,$response[0]->Categoria_idCategoria,$response[0]->stock);
            $product->setID($response[0]->idProducto);
            $product->setAverage($response[0]->promedio);
            $product->loadComments();
        }
        return $product;
    }

    public function updateProduct(){
        DB::update("call actualizarProducto(".$this->id.",'".$this->nombre."','".$this->descripcion."','".$this->imagen."',".$this->precio.",".$this->stock.",".$this->categoria.");");
    }

    public function deleteProduct(){
        DB::update('call deleteProducto('.$this->id.');');
        $this->setState(0);
    }

    public static function search($filtro,$catID){
        return DB::select("call busqueda_producto('".$filtro."',".$catID.");");
    }

    public static function productsByCategory($categoria){
        return DB::select("CALL productos_x_categoria(".$categoria.");");
    }

    public static function productInStock($id){
        return DB::select("call verificarProducto(".$id.");");
    }

    public function rate($user,$comment,$rating){
        $nuevo = new Comment($comment,$rating,$this->id,$user);
        $nuevo->saveComment();
    }

    public function loadComments(){
        $this->comentarios = Comment::getComments($this->id);
    }

}
