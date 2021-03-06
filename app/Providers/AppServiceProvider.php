<?php

namespace tiendaVirtual\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Dusk\DuskServiceProvider;
use tiendaVirtual\Category;
use tiendaVirtual\Cart;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      $categories = Category::where('enable',1)->get();
      $data = [
        'categorias' => $categories
      ];
      view()->share('data', $data);
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      if ($this->app->environment('local', 'testing')) {
        $this->app->register(DuskServiceProvider::class);
      }
    }
}
