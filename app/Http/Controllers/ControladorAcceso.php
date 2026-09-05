<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ControladorAcceso extends Controller
{
    public function mostrarCorreo(): View
    {
        return view('acceso.correo');
    }

    public function validarCorreo(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'correoElectronico' => ['required', 'email'],
        ]);

        $usuarioExiste = Usuario::query()
            ->where('correoElectronico', $datos['correoElectronico'])
            ->exists();

        if (! $usuarioExiste) {
            return back()
                ->withErrors(['correoElectronico' => 'El correo ingresado no se encuentra registrado.'])
                ->onlyInput('correoElectronico');
        }

        $request->session()->put('correoAcceso', $datos['correoElectronico']);

        return redirect()->route('acceso.clave');
    }

    public function mostrarClave(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('correoAcceso')) {
            return redirect()->route('acceso.correo');
        }

        return view('acceso.clave', [
            'correoElectronico' => $request->session()->get('correoAcceso'),
        ]);
    }

    public function iniciarSesion(Request $request): RedirectResponse
    {
        $correoElectronico = $request->session()->get('correoAcceso');

        if (! $correoElectronico) {
            return redirect()->route('acceso.correo');
        }

        $datos = $request->validate([
            'clave' => ['required', 'string'],
        ]);

        $credenciales = [
            'correoElectronico' => $correoElectronico,
            'password' => $datos['clave'],
        ];

        if (! Auth::attempt($credenciales)) {
            return back()->withErrors(['clave' => 'La clave ingresada es incorrecta.']);
        }

        $request->session()->regenerate();
        $request->session()->forget('correoAcceso');
        $request->session()->put('dobleFactorVerificado', false);

        /** @var Usuario $usuario */
        $usuario = Auth::user();

        if ($usuario->cambiarClave) {
            return redirect()->route('configuracion.cambiarClave');
        }

        if ($usuario->dobleFactorHabilitado) {
            return redirect()->route('dobleFactor.confirmar');
        }

        return redirect()->route('principal');
    }

    public function cerrarSesion(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('acceso.correo');
    }
}
