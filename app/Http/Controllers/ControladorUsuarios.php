<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ControladorUsuarios extends Controller
{
    public function crear(): View
    {
        return view('usuarios.crear');
    }

    public function guardar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'correoElectronico' => ['required', 'email', 'max:190', 'unique:usuarios,correoElectronico'],
        ]);

        $claveGenerica = (string) config('app.claveGenerica');

        Usuario::query()->create([
            'nombre' => $datos['nombre'],
            'correoElectronico' => $datos['correoElectronico'],
            'clave' => Hash::make($claveGenerica),
            'cambiarClave' => true,
            'dobleFactorHabilitado' => false,
        ]);

        return redirect()->route('usuarios.crear')
            ->with('estado', 'Usuario creado correctamente. Clave genérica: '.$claveGenerica);
    }
}
