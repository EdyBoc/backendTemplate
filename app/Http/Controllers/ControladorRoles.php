<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ControladorRoles extends Controller
{
    public function crear(): View
    {
        return view('roles.crear');
    }

    public function guardar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100', 'unique:roles,nombre'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ]);

        Rol::query()->create($datos);

        return redirect()->route('roles.crear')
            ->with('estado', 'Rol creado correctamente.');
    }
}
