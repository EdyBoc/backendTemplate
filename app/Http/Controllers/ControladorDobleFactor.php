<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Services\ServicioDobleFactor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ControladorDobleFactor extends Controller
{
    public function __construct(private readonly ServicioDobleFactor $servicioDobleFactor) {}

    public function mostrar(Request $request): View
    {
        /** @var Usuario $usuario */
        $usuario = $request->user();

        $secretoTemporal = null;
        $uriConfiguracion = null;
        $secretoTemporal = null;
        $uriConfiguracion = null;
        $codigoQr = null;

        if (! $usuario->dobleFactorHabilitado) {
            $secretoTemporal = $request->session()->get('dobleFactorSecretoTemporal');

            if (! $secretoTemporal) {
                $secretoTemporal = $this->servicioDobleFactor->generarSecreto();
                $request->session()->put('dobleFactorSecretoTemporal', $secretoTemporal);
            }

            $uriConfiguracion = $this->servicioDobleFactor->generarUri(
                $usuario->correoElectronico,
                $secretoTemporal,
                (string) config('app.name')
            );

            $codigoQr = $this->servicioDobleFactor->generarCodigoQr($uriConfiguracion);
        }

        return view('configuracion.dobleFactor', compact('usuario', 'secretoTemporal', 'uriConfiguracion', 'codigoQr'));
    }

    public function activar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'codigo' => ['required', 'digits:6'],
        ]);

        $secretoTemporal = $request->session()->get('dobleFactorSecretoTemporal');

        if (! $secretoTemporal || ! $this->servicioDobleFactor->verificarCodigo($secretoTemporal, $datos['codigo'])) {
            return back()->withErrors(['codigo' => 'El código de autenticación no es válido.']);
        }

        /** @var Usuario $usuario */
        $usuario = $request->user();
        $usuario->dobleFactorSecreto = $secretoTemporal;
        $usuario->dobleFactorHabilitado = true;
        $usuario->save();

        $request->session()->forget('dobleFactorSecretoTemporal');
        $request->session()->put('dobleFactorVerificado', true);

        return redirect()->route('dobleFactor')
            ->with('estado', 'Autenticación de doble factor activada correctamente.');
    }

    public function desactivar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'claveActual' => ['required', 'string'],
        ]);

        /** @var Usuario $usuario */
        $usuario = $request->user();

        if (! Hash::check($datos['claveActual'], $usuario->clave)) {
            return back()->withErrors(['claveActual' => 'La clave actual es incorrecta.']);
        }

        $usuario->dobleFactorSecreto = null;
        $usuario->dobleFactorHabilitado = false;
        $usuario->save();

        $request->session()->put('dobleFactorVerificado', false);

        return redirect()->route('dobleFactor')
            ->with('estado', 'Autenticación de doble factor desactivada.');
    }

    public function mostrarConfirmacion(Request $request): View|RedirectResponse
    {
        /** @var Usuario $usuario */
        $usuario = $request->user();

        if (! $usuario->dobleFactorHabilitado) {
            return redirect()->route('principal');
        }

        if ($request->session()->get('dobleFactorVerificado', false)) {
            return redirect()->route('principal');
        }

        return view('acceso.dobleFactor');
    }

    public function confirmar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'codigo' => ['required', 'digits:6'],
        ]);

        /** @var Usuario $usuario */
        $usuario = $request->user();

        if (! $usuario->dobleFactorSecreto || ! $this->servicioDobleFactor->verificarCodigo($usuario->dobleFactorSecreto, $datos['codigo'])) {
            return back()->withErrors(['codigo' => 'El código de autenticación no es válido.']);
        }

        $request->session()->put('dobleFactorVerificado', true);

        return redirect()->route('principal');
    }
}
