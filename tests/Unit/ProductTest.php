<?php

namespace Tests\Unit;

use Tests\TestCase;
use tiendaVirtual\Category;
use tiendaVirtual\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DB;

class ProductTest extends TestCase
{
    use DatabaseTransactions;
    protected $categoria;
    protected $producto;
    private $cantidadProductos;

    public function setUp() {
      parent::setUp();
      $this->categoria = factory(Category::class)->create();
      $this->cantidadProductos = count(DB::select('call getProductos()'));
      $this->producto = new Product('Figura', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor', 'play1.jpg', '2000', $this->categoria->idCategoria, '10');
      $this->producto->saveProduct();
    }

    /** @test */
    public function GetProductosIsWorking_CallGetProductos_ReturnsTrue() {
        $this->cantidadProductos += 1;
        $this->assertEquals(count(DB::select('call getProductos()')), $this->cantidadProductos);
    }

    /** @test */
    public function GetProductosHabilitadosIsWorking_CallGetProductosHabilitados_ReturnsTrue() {
      $habilitados = count(DB::select('select * from producto where estado = 1'));
      $this->assertEquals(count(DB::select('call getProductosHabilitados()')), $habilitados);
    }

    /** @test */
    public function GetProductPorIdIsWorking_CallBuscarProducto_ReturnsTrue() {
        $retorno = DB::select("call buscarProductoxID(".$this->producto->idProducto.")");
        $this->assertEquals($retorno[0]->idProducto, $this->producto->idProducto);
    }

    /** @test */
    public function UpdateProductName_CallActualizar_ReturnsTrue() {
      $nuevoNombre = 'Play Station';
      $this->producto->setName($nuevoNombre);
      $this->producto->updateProduct();
      $this->assertEquals($nuevoNombre, DB::select('call verificarProducto('.$this->producto->idProducto.')')[0]->nombre);
    }

    /** @test */
    public function DeleteProduct_CallDeleteProducto_ReturnsTrue() {
      $this->producto->deleteProduct();
      $this->assertEquals($this->producto->getState(), DB::select('call verificarProducto('.$this->producto->idProducto.')')[0]->estado);
    }

    /** @test */
    public function BuscarProduct_CallBusquedaProducto_ReturnsTrue() {
      $filtro = 'ura';
      $this->assertEquals(1, count($this->producto->buscar($filtro)));
    }

    /** @test */
    public function ProbarHayInventario_CallVerificarProducto_ReturnsFalse() {
      $this->producto->setStock('0');
      $this->producto->updateProduct();
      // Lista vacía ya que el producto no tiene suficientes ejemplares para vender
      $this->assertEquals([],$this->producto->hayEnInventario($this->producto->idProducto));
    }
}
