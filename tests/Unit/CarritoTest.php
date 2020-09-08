<?php

namespace Tests\Unit;

use Tests\TestCase;
use tiendaVirtual\Carrito;
use tiendaVirtual\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DB;

class CarritoTest extends TestCase
{
    use DatabaseTransactions;
    protected $user;

    public function setUp() {
      parent::setUp();
      $this->user = factory(User::class)->create(['admin' => '0']);
    }

    /** @test */
    public function testExample()
    {
        Carrito::registrarCarrito($this->user->email);
        $idCarrito = DB::select('select idCarrito from Carrito where Usuario_correo = "'.$this->user->email.'"')[0]->idCarrito;
        $this->assertEquals(Carrito::getID(),$idCarrito);
    }
}
