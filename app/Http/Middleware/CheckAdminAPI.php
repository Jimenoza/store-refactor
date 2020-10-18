<?php

namespace tiendaVirtual\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminAPI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->user()->admin){
            return response()->json(['data' => 'Forbidden','error' => 403]);
        }
        return $next($request);
    }
}
