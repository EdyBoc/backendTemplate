<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ControladorAsignacionRoles extends Controller
{
    public function mostrar(): View
    {
        return view('roles.asignar', [
            'usuarios' => Usuario::query()->orderBy('nombre')->get(),
            'roles' => Rol::query()->orderBy('nombre')->get(),
        ]);
    }

    public function asignar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'usuarioId' => ['required', 'integer', 'exists:usuarios,id'],
            'rolId' => ['required', 'integer', 'exists:roles,id'],
        ]);

        $usuario = Usuario::query()->findOrFail($datos['usuarioId']);
        $usuario->roles()->syncWithoutDetaching([$datos['rolId']]);

        return redirect()->route('roles.asignar')
            ->with('estado', 'Rol asignado correctamente.');
    }
}
