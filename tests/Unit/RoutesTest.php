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
      $urlsInApp = ['/admin', '/cliente/','/usuarios/inicioSesionRegistro','/carrito/orden',];
      $urlsRedirect = ['/','logout', '/adminInicio', '/admin/configuraciones','/cliente/vermetodos', '/admin/crearAdmin','/admin/actualizarContrasena','/admin/agregarCategoria','/admin/editarCategoria',
      '/admin/indexCategoria','/admin/eliminarCategoria','/admin/agregarProducto','/admin/indexProducto',
      '/admin/editarProducto','/admin/eliminarProducto','/cuenta','/usuarios/cierreSesion','/carrito/agregar/1',
      '/carrito/cart','/carrito/eliminar','/cliente/pagar','/cliente/ordenes'];
      $urlsNotSupportMethod = ['/admin/revisarContrasena'];
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
