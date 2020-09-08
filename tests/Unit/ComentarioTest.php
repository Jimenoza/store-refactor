<?php

namespace Tests\Unit;

use Tests\TestCase;
use tiendaVirtual\Comentario;
use tiendaVirtual\Producto;
use tiendaVirtual\Categoria;
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
      $this->categoria = factory(Categoria::class)->create();
      $this->user = factory(User::class)->create(['admin' => '0']);
      $this->cantidadProductos = count(DB::select('call getProductos()'));
      $this->producto = new Producto('Figura', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor', 'play1.jpg', '2000', $this->categoria->idCategoria, '10');
      $this->producto->guardar();
      $this->comentario = new Comentario('Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4, $this->producto->getID(), $this->user->email);
    }

    /** @test */
    public function IsCommentStoreInDB_CallGuardar_ReturnsTrue()
    {
        $this->comentario->guardar();
        $getComentarioGuardado = DB::select('select * from calificacion_x_producto where idUsuario = "'.$this->user->email.'"')[0]->comentario;
        $this->assertEquals($getComentarioGuardado,$this->comentario->getTexto());
    }

    /** @test */
    public function IsCommentStoreInDB_CallGetComentarios_ReturnsTrue()
    {
        $this->comentario->guardar();
        $this->assertEquals(1,count($this->comentario->getComentarios($this->producto->getID()) ));
    }
}
