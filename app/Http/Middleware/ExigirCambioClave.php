<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExigirCambioClave
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->cambiarClave) {
            return redirect()->route('configuracion.cambiarClave');
        }

        return $next($request);
    }
}
