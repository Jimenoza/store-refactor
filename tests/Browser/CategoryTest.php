<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use tiendaVirtual\Category;
use tiendaVirtual\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryTest extends DuskTestCase
{
    protected $user;
    protected $categoria;

    /*
     La linea ->type('searchVar', <cadena_a_buscar>) se utiliza para evitar presionar
     next n veces hasta encontrar la categoria ingresada
    */

    public function setUp() {
      parent::setUp();
      $this->user = factory(User::class)->create(['admin' => '1']);
      $this->categoria = factory(Category::class)->create();
    }


        /** @test */
        public function IsCategoryEditWorking_GoodEntries_GoToIndexCategoriaPage()
        {
            $categoria = factory(Category::class)->make();
            $this->browse(function (Browser $browser) use ($categoria){
                $browser->visit('/admin')
                        ->type('email', $this->user->email)
                        ->type('password', 'secret')
                        ->press('Login')
                        ->visit('/admin/indexCategoria')
                        ->type('#searchVar', $this->categoria->descripcion)
                        ->click('#edit_'.$this->categoria->nombre)
                        ->type('nombre', $categoria->nombre)
                        ->type('descripcion', $categoria->descripcion)
                        ->type('condicion', '0')
                        ->press('Editar Categoría')
                        ->type('#searchVar', $categoria->descripcion)
                        ->assertSeeIn('.idCategoria ',$this->categoria->idCategoria);
            });
            $this->categoria->nombre = $categoria->nombre;
            $this->categoria->descripcion = $categoria->descripcion;
        }

        /** @test */
        public function IsCategoryEditWorking_ConditionEntryNegativeNumber_StayInEditarCategoriaPage()
        {
            $categoria = factory(Category::class)->make();
            $this->browse(function (Browser $browser) use ($categoria){
                $browser->visit('/admin')
                        ->type('email', $this->user->email)
                        ->type('password', 'secret')
                        ->press('Login')
                        ->visit('/admin/indexCategoria')
                        ->type('searchVar', $this->categoria->descripcion)
                        ->click('#edit_'.$this->categoria->nombre)
                        ->type('nombre', $categoria->nombre)
                        ->type('descripcion', $categoria->descripcion)
                        ->type('condicion', '-1')
                        ->press('Editar Categoría')
                        ->assertPathIs('/admin/editarCategoria/'.$this->categoria->idCategoria);
            });
        }

        /** @test */
        public function IsCategoryEditWorking_ConditionEntryUpperLimitNumber_StayInEditarCategoriaPage()
        {
            $categoria = factory(Category::class)->make();
            $this->browse(function (Browser $browser) use ($categoria){
                $browser->visit('/admin')
                        ->type('email', $this->user->email)
                        ->type('password', 'secret')
                        ->press('Login')
                        ->visit('/admin/indexCategoria')
                        ->type('searchVar', $this->categoria->descripcion)
                        ->click('#edit_'.$this->categoria->nombre)
                        ->type('nombre', $categoria->nombre)
                        ->type('descripcion', $categoria->descripcion)
                        ->type('condicion', '2')
                        ->press('Editar Categoría')
                        ->assertPathIs('/admin/editarCategoria/'.$this->categoria->idCategoria);
            });
        }

        /** @test */
        public function IsCategoryEditButtonWorking_ClickCategoryEditButton_GoToPageEditCategory()
        {
          $this->browse(function (Browser $browser) {
              $browser->visit('/admin')
                      ->type('email', $this->user->email)
                      ->type('password', 'secret')
                      ->press('Login')
                      ->visit('/admin/indexCategoria')
                      ->type('searchVar', $this->categoria->descripcion)
                      ->click('#edit_'.$this->categoria->nombre)
                      ->assertPathIs('/admin/editarCategoria/'.$this->categoria->idCategoria);
            });
        }

        /** @test */
        public function IsCategoryDeleteButtonWorking_ClickCategoryDeleteButtonThenAccept_CondicionValueIsZeroInIndexView()
        {
          $this->browse(function (Browser $browser) {
              $browser->visit('/admin')
                      ->type('email', $this->user->email)
                      ->type('password', 'secret')
                      ->press('Login')
                      ->visit('/admin/indexCategoria')
                      ->type('searchVar', $this->categoria->descripcion)
                      ->click('#eliminar_'.$this->categoria->idCategoria)
                      ->acceptDialog()
                      ->assertSeeIn('.condicionCategoria', '0');
            });
        }

    /** @test */
    public function IsCategoryInsertWorking_GoodEntries_CategoryAddIt()
    {
        $categoria = factory(Category::class)->make();
        $this->browse(function (Browser $browser) use ($categoria){
            $browser->visit('/admin')
                    ->type('email', $this->user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->visit('/admin/agregarCategoria')
                    ->type('nombre', $categoria->nombre)
                    ->type('descripcion', $categoria->descripcion)
                    ->press('Agregar Categoría')
                    ->assertPathIs('/admin/indexCategoria');
        });
    }

    /** @test */
    public function IsCategoryInsertWorking_EmptyEntries_StayInAgregarCategoria()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                    ->type('email', $this->user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->visit('/admin/agregarCategoria')
                    ->type('nombre', '')
                    ->type('descripcion', '')
                    ->press('Agregar Categoría')
                    ->assertPathIs('/admin/agregarCategoria');
        });
    }

    /** @test */
    public function IsCategoryInsertWorking_EmptyName_StayInAgregarCategoria()
    {
        $categoria = factory(Category::class)->make();
        $this->browse(function (Browser $browser) use ($categoria){
            $browser->visit('/admin')
                    ->type('email', $this->user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->visit('/admin/agregarCategoria')
                    ->type('nombre', '')
                    ->type('descripcion', $categoria->descripcion)
                    ->press('Agregar Categoría')
                    ->assertPathIs('/admin/agregarCategoria');
        });
    }

    /** @test */
    public function IsCategoryInsertWorking_EmptyDescription_StayInAgregarCategoria()
    {
        $categoria = factory(Category::class)->make();
        $this->browse(function (Browser $browser) use ($categoria){
            $browser->visit('/admin')
                    ->type('email', $this->user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->visit('/admin/agregarCategoria')
                    ->type('nombre', $categoria->nombre)
                    ->type('descripcion', '')
                    ->press('Agregar Categoría')
                    ->assertPathIs('/admin/agregarCategoria');
        });
    }

    /** @test */
    public function IsCategoryInsertWorking_UpLimitsEntries_StayInAgregarCategoria()
    {
        $categoria = factory(Category::class)->make(['nombre'=>'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'descripcion' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.']);
        $this->browse(function (Browser $browser) use ($categoria){
            $browser->visit('/admin')
                    ->type('email', $this->user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->visit('/admin/agregarCategoria')
                    ->type('nombre', $categoria->nombre)
                    ->type('descripcion', $categoria->descripcion)
                    ->press('Agregar Categoría')
                    ->assertPathIs('/admin/agregarCategoria');
        });
    }

    /** @test */
    public function IsCategoryInsertWorking_BottomLimitName_StayInAgregarCategoria()
    {
        $categoria = factory(Category::class)->make(['nombre'=>'a']);
        $this->browse(function (Browser $browser) use ($categoria){
            $browser->visit('/admin')
                    ->type('email', $this->user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->visit('/admin/agregarCategoria')
                    ->type('nombre', $categoria->nombre)
                    ->type('descripcion', $categoria->descripcion)
                    ->press('Agregar Categoría')
                    ->assertPathIs('/admin/agregarCategoria');
        });
    }

    /** @test */
    public function IsCategoryShowingInIndexPage_CategoryShows_CategoryNameInPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                    ->type('email', $this->user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->visit('/admin/indexCategoria')
                    ->type('searchVar', $this->categoria->descripcion)
                    ->assertSee($this->categoria->nombre);
        });
    }
}
