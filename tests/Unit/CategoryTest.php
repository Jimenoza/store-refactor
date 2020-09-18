<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use tiendaVirtual\Category;
use tiendaVirtual\User;
use DB;

class CategoryTest extends TestCase
{
    protected $categorias;
    protected $categoria;

    public function setUp() {
      parent::setUp();
      $this->categorias = count(DB::select("call getCategorias()"));
      $this->categoria = factory(Category::class,10)->create();
      $this->categorias += 10;
    }

    /** @test */
    public function IsGetCategoriasWorkin_CallGetCategorias_ReturnTrue()
    {
      $todasLasCategorias = count(Category::getCategories());
      $this->assertEquals($todasLasCategorias, $this->categorias);
    }

}
