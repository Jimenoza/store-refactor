<?php
namespace Tests\Unit;

use Tests\TestCase;
use tiendaVirtual\Tarjeta;
use tiendaVirtual\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DB;

class TarjetaTest extends TestCase
{
    use DatabaseTransactions;
    protected $tarjeta;
    protected $user;

    public function setUp() {
      parent::setUp();
      $this->user = factory(User::class)->create(['admin' => '0']);
      $this->tarjeta = new Tarjeta('ALONSO PEREZ ARAYA', '1234123412341234', '001', '2022-10-01', $this->user->email);
      $this->tarjeta->nuevaTarjeta();
    }

    /** @test */
    public function testExample()
    {
        $this->assertEquals(1,count($this->tarjeta->verTarjetas($this->user->email)));
    }
}
