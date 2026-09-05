<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ControladorConfiguracion extends Controller
{
    public function mostrar(): View
    {
        return view('configuracion.principal');
    }

    public function mostrarCambioClave(): View
    {
        return view('configuracion.cambiarClave');
    }

    public function cambiarClave(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'claveActual' => ['required', 'string'],
            'claveNueva' => ['required', 'confirmed', Password::min(8)],
        ]);

        /** @var Usuario $usuario */
        $usuario = $request->user();

        if (! Hash::check($datos['claveActual'], $usuario->clave)) {
            return back()->withErrors(['claveActual' => 'La clave actual es incorrecta.']);
        }

        if (Hash::check($datos['claveNueva'], $usuario->clave)) {
            return back()->withErrors(['claveNueva' => 'La clave nueva debe ser diferente a la actual.']);
        }

        $usuario->clave = Hash::make($datos['claveNueva']);
        $usuario->cambiarClave = false;
        $usuario->save();

        if ($usuario->dobleFactorHabilitado && ! $request->session()->get('dobleFactorVerificado', false)) {
            return redirect()->route('dobleFactor.confirmar')
                ->with('estado', 'Clave actualizada correctamente.');
        }

        return redirect()->route('principal')
            ->with('estado', 'Clave actualizada correctamente.');
    }
}
