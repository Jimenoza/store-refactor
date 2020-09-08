<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use tiendaVirtual\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminLoginTest extends DuskTestCase
{
    protected $user;

    public function setUp() {
      parent::setUp();
      $this->user = factory(User::class)->create(['admin' => '1']);
    }
    /** @test */
    public function IsValidUserForLogin_GoodUser_ReturnsTrue() {
      $this->browse(function ($browser) {
            $browser->visit('/admin')
                    ->type('email', $this->user->email)
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertPathIs('/admin/indexProducto');
        });
    }
    /** @test */
    public function IsValidPassswordForLogin_WrongPassword_StayInAdminLoginPage() {
      $this->browse(function ($browser) {
            $browser->visit('/admin')
                    ->type('email', $this->user->email)
                    ->type('password', 'secreto')
                    ->press('Login')
                    ->assertPathIs('/admin');
        });
    }
    /** @test */
    public function IsValidPassswordForLogin_EmptyPassword_StayInAdminLoginPage() {
      $this->browse(function ($browser) {
            $browser->visit('/admin')
                    ->type('email', $this->user->email)
                    ->type('password', '')
                    ->press('Login')
                    ->assertPathIs('/admin');
        });
    }
    /** @test */
    public function IsValidUserForLogin_WrongEmail_StayInAdminLoginPage() {
      $this->browse(function ($browser) {
            $browser->visit('/admin')
                    ->type('email', 'superman@gmail.com')
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertPathIs('/admin');
        });
    }
    /** @test */
    public function IsEmptyDataForLogin_ButtonLoginPressed_StayInAdminLoginPage() {
      $this->browse(function ($browser) {
            $browser->visit('/admin')
                    ->press('Login')
                    ->assertPathIs('/admin');
        });
    }

    /** @test */
    public function IsLogOutWorking_LogOutSession_AdminLogInPage() {
      $this->browse(function ($browser) {
        $browser->visit('/admin')
                ->type('email', $this->user->email)
                ->type('password', 'secret')
                ->press('Login')
                ->click('#logOut')
                ->assertPathIs('/cliente');
        });
    }
}
