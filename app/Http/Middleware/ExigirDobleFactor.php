<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExigirDobleFactor
{
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = $request->user();

        if ($usuario?->dobleFactorHabilitado && ! $request->session()->get('dobleFactorVerificado', false)) {
            return redirect()->route('dobleFactor.confirmar');
        }

        return $next($request);
    }
}
