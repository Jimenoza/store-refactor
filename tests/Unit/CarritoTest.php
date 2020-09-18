<?php

namespace Tests\Unit;

use Tests\TestCase;
use tiendaVirtual\Cart;
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
        Cart::registerCart($this->user->email);
        $idCarrito = DB::select('select idCarrito from Carrito where Usuario_correo = "'.$this->user->email.'"')[0]->idCarrito;
        $this->assertEquals(Cart::getID(),$idCarrito);
    }
}
