<?php

namespace Tests\Unit;

use Tests\TestCase;
use tiendaVirtual\Comment;
use tiendaVirtual\Product;
use tiendaVirtual\Category;
use tiendaVirtual\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DB;

class ComentarioTest extends TestCase
{
    use DatabaseTransactions;
    protected $categoria;
    protected $producto;
    protected $comentario;
    protected $user;

    public function setUp() {
      parent::setUp();
      $this->categoria = factory(Category::class)->create();
      $this->user = factory(User::class)->create(['admin' => '0']);
      $this->cantidadProductos = count(DB::select('call getProductos()'));
      $this->producto = new Product('Figura', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor', 'play1.jpg', '2000', $this->categoria->idCategoria, '10');
      $this->producto->saveProduct();
      $this->comentario = new Comment('Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4, $this->producto->idProducto, $this->user->email);
    }

    /** @test */
    public function IsCommentStoreInDB_CallGuardar_ReturnsTrue()
    {
        $this->comentario->saveComment();
        $getComentarioGuardado = DB::select('select * from calificacion_x_producto where idUsuario = "'.$this->user->email.'"')[0]->comentario;
        $this->assertEquals($getComentarioGuardado,$this->comentario->getText());
    }

    /** @test */
    public function IsCommentStoreInDB_CallGetComentarios_ReturnsTrue()
    {
        $this->comentario->saveComment();
        $this->assertEquals(1,count($this->comentario->getComentarios($this->producto->getID()) ));
    }
}
