<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use tiendaVirtual\Categoria;
use tiendaVirtual\User;
use tiendaVirtual\Producto;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductTest extends DuskTestCase
{
    protected $user;
    protected $categoria;
    protected $producto;

    public function setUp() {
      parent::setUp();
      $this->user = factory(User::class)->create(['admin' => '1']);
      $this->categoria = factory(Categoria::class)->create();
    }

    /** @test */
    public function IsProductIndexProductoDisplay_GoToRoute_GoToIndexProductoPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                    ->type('email', $this->user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->visit('/admin/indexProducto')
                    ->assertPathIs('/admin/indexProducto');
        });
    }

    /** @test */
    public function IsProductoCreateCorrectly_GoodEntries_ProductoListPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                    ->type('email', $this->user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->visit('/admin/agregarProducto')
                    ->type('nombre', 'Max Steel')
                    ->click('.select2-choice')
                    ->type('searcher', $this->categoria->nombre)
                    ->keys('.select2-input','{enter}')
                    ->type('descripcion', 'Lorem ipsum dolor sit amet')
                    ->attach('imageInput', 'C:\Users\papin\Desktop\maxSteel.jpg')
                    ->type('precio', '700.90')
                    ->type('disponibles', '90')
                    ->press('Agregar Producto')
                    ->assertPathIs('/admin/indexProducto');
        });
    }

}
