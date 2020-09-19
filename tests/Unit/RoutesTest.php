<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoutesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRoutes() {
      $urlsInApp = ['/admin', '/cliente/','/login/page','/carrito/orden',];
      $urlsRedirect = ['/','logout', '/adminInicio', '/admin/configs','/cliente/vermetodos', '/admin/new/admin','/admin/password/change','/admin/category/new','/admin/category/edit',
      '/admin/category/index','/admin/category/delete','/admin/product/new','/admin/product/index',
      '/admin/product/edit','/admin/product/delete','/cuenta','/logout','/cart/add/1',
      '/carrito/cart','/cart/delete','/cliente/pagar','/orders'];
      $urlsNotSupportMethod = ['/admin/password/check'];
       foreach($urlsInApp as $url){
         $this->IsValidRoute_GoodRoute_ReturnsTrue($url);
       }
       foreach ($urlsRedirect as $url) {
         $this->IsValidRoute_RedirectRoute_ReturnsTrue($url);
       }
        $this->assertTrue(true);
    }
    public function IsValidRoute_GoodRoute_ReturnsTrue($url)
    {
      $response = $this->get($url);

      $response->assertStatus(200); //Estrada correcta a la ruta
    }

    public function IsValidRoute_RedirectRoute_ReturnsTrue($url)
    {
      $response = $this->get($url);
      $response->assertStatus(302); //Redireccionamiento de la ruta
    }
}
