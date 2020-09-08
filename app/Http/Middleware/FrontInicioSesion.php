<?php

namespace tiendaVirtual\Http\Middleware;

use Closure;
use Session;

class FrontInicioSesion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (empty(Session::has('frontSession'))) {
          return redirect('/usuarios/registrar');
        }
        return $next($request);
    }
}
