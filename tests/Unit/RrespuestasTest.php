<?php

namespace Tests\Unit;

use Tests\TestCase;
use tiendaVirtual\Category;
use tiendaVirtual\Producto;
use tiendaVirtual\Respuesta;
use tiendaVirtual\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DB;

class RrespuestasTest extends TestCase
{
    use DatabaseTransactions;
    protected $user;
    protected $respuesta;

    public function setUp() {
      parent::setUp();
      $this->user = factory(User::class)->create(['admin' => '0']);
      $this->respuesta = new Respuesta('Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 1, $this->user->email);
    }

    /** @test */
    public function testExample()
    {
        $this->respuesta->guardar();
        $this->assertTrue(DB::select('select * from respuestas where idUsuario = "'.$this->user->email.'"'));
    }
}
