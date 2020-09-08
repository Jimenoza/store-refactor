<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use tiendaVirtual\Categoria;
use tiendaVirtual\User;
use DB;

class CategoryTest extends TestCase
{
    protected $categorias;
    protected $categoria;

    public function setUp() {
      parent::setUp();
      $this->categorias = count(DB::select("call getCategorias()"));
      $this->categoria = factory(Categoria::class,10)->create();
      $this->categorias += 10;
    }

    /** @test */
    public function IsGetCategoriasWorkin_CallGetCategorias_ReturnTrue()
    {
      $todasLasCategorias = count(Categoria::getCategorias());
      $this->assertEquals($todasLasCategorias, $this->categorias);
    }

}
