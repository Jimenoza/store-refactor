<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use tiendaVirtual\User;
use tiendaVirtual\Categoria;
use tiendaVirtual\Producto;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;

class ClienteTest extends DuskTestCase
{
    protected $user;
    protected $categoria;
    protected $producto;

    public function setUp() {
      parent::setUp();
      $this->user = factory(User::class)->create(['admin' => '0']);
      $this->categoria = factory(Categoria::class)->create();
    }
    /** @test */
    public function IsTheHomePageWorking_RouteToHome_TiendaVirtualShows()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/cliente')
                    ->assertSee('Tienda Virtual');
        });
    }

    /** @test */
    public function CanTheAppRegisterCorrectly_GoodEntries_UserNameDisplaysInLogin()
    {
        $user = factory(User::class)->make(['admin'=>'0']);
        $this->browse(function (Browser $browser) use ($user){
            $browser->visit('/cliente')
                    ->click('#register')
                    ->type('nombreRegistrar', $user->name)
                    ->type('correoRegistrar', $user->email)
                    ->type('contrasenaRegistrar', 'secret')
                    ->press('Registrarse')
                    ->visit('/cliente')
                    ->click('#iniciarSesion')
                    ->type('correo', $user->email)
                    ->type('contrasena', 'secret')
                    ->press('Iniciar Sesión')
                    ->assertSeeIn('#welcomeUser', 'Bienvenido '.$user->nombre);
        });
        $this->user->name = $user->name;
        $this->user->email = $user->email;
    }

    /** @test */
    public function CanTheAppShowCategoriaPageCorrectly_ClickDropdownMenuCategoriasSelectCategoria_CategoriaPageShows()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/cliente')
                    ->mouseover('.cat_menu_text')
                    ->click('#categoria_'.$this->categoria->idCategoria)
                    ->assertPathIs('/cliente/categories/'.$this->categoria->idCategoria);
        });
    }

    /** @test */
    public function CanTheAppShowCartPageCorrectly_ClickCarrito_CartPageShows()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/cliente')
                    ->click('#carrito')
                    ->assertPathIs('/cliente/cart');
        });
    }

    /** @test */
    public function CanTheAppLoginCorrectly_NormalUserEntry_UserNameDisplays()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/cliente/')
                    ->click('#cerrarSesion')
                    ->click('#iniciarSesion')
                    ->type('correo', $this->user->email)
                    ->type('contrasena', 'secret')
                    ->press('Iniciar Sesión')
                    ->assertSeeIn('#welcomeUser', 'Bienvenido '.$this->user->nombre);
        });
    }

    /** @test */
    public function CanTheAppShowProductPageCorrectly_ClickProducto_ProductoPageShows()
    {
        $countProductos = count(DB::select('call getProductos()'));
        $this->browse(function (Browser $browser) use ($countProductos){
            $browser->visit('/cliente');
            // Se utiliza el script de click en elemento debido a que el scrollTo no funcionaba como se debía
            $browser->script('document.getElementsByClassName("productoSlider_'.$countProductos.'")[0].click();');
            $browser->assertPathIs('/cliente/product/'.$countProductos);
        });
    }

    /** @test */
    public function CanTheAppSAddProductoToCartCorrectly_ClickAddProducto_()
    {
        $countProductos = count(DB::select('call getProductos()'));
        $this->browse(function (Browser $browser) use ($countProductos){
            $browser->visit('/cliente');
            // Se utiliza el script de click en elemento debido a que el scrollTo no funcionaba como se debía
            $browser->script('document.getElementById("addCart_'.$countProductos.'").click();');
            $browser->click('#carrito')
                    ->assertSeeIn('.cart_button_clear','Quitar');
        });
    }
    // /** @test */
    // public function CanTheAppSAddProductoToCartCorrectly_ClickAddProducto_()
    // {
    //     $countProductos = count(DB::select('call getProductos()'));
    //     $this->browse(function (Browser $browser) use ($countProductos){
    //         $browser->visit('/cliente');
    //         // Se utiliza el script de click en elemento debido a que el scrollTo no funcionaba como se debía
    //         $browser->script('document.getElementById("addCart_'.$countProductos.'").click();');
    //         $browser->click('#carrito')
    //                 ->assertSeeIn('.cart_button_clear','Quitar');
    //     });
    // }
}
