<?php

use App\Http\Controllers\ControladorAcceso;
use App\Http\Controllers\ControladorAsignacionRoles;
use App\Http\Controllers\ControladorConfiguracion;
use App\Http\Controllers\ControladorDobleFactor;
use App\Http\Controllers\ControladorPrincipal;
use App\Http\Controllers\ControladorRoles;
use App\Http\Controllers\ControladorUsuarios;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('acceso.correo'));

Route::middleware('guest')->group(function (): void {
    Route::get('/acceso', [ControladorAcceso::class, 'mostrarCorreo'])->name('acceso.correo');
    Route::post('/acceso', [ControladorAcceso::class, 'validarCorreo'])->name('acceso.validarCorreo');
    Route::get('/acceso/clave', [ControladorAcceso::class, 'mostrarClave'])->name('acceso.clave');
    Route::post('/acceso/clave', [ControladorAcceso::class, 'iniciarSesion'])->name('acceso.iniciarSesion');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/salir', [ControladorAcceso::class, 'cerrarSesion'])->name('acceso.salir');

    Route::get('/cambiarClave', [ControladorConfiguracion::class, 'mostrarCambioClave'])->name('configuracion.cambiarClave');
    Route::post('/cambiarClave', [ControladorConfiguracion::class, 'cambiarClave'])->name('configuracion.guardarClave');

    Route::get('/dobleFactor/confirmar', [ControladorDobleFactor::class, 'mostrarConfirmacion'])->name('dobleFactor.confirmar');
    Route::post('/dobleFactor/confirmar', [ControladorDobleFactor::class, 'confirmar'])->name('dobleFactor.validar');
});

Route::middleware(['auth', 'cambioClave', 'dobleFactor'])->group(function (): void {
    Route::get('/principal', [ControladorPrincipal::class, 'mostrar'])->name('principal');

    Route::get('/configuracion', [ControladorConfiguracion::class, 'mostrar'])->name('configuracion');
    Route::get('/dobleFactor', [ControladorDobleFactor::class, 'mostrar'])->name('dobleFactor');
    Route::post('/dobleFactor/activar', [ControladorDobleFactor::class, 'activar'])->name('dobleFactor.activar');
    Route::post('/dobleFactor/desactivar', [ControladorDobleFactor::class, 'desactivar'])->name('dobleFactor.desactivar');

    Route::get('/usuarios/crear', [ControladorUsuarios::class, 'crear'])->name('usuarios.crear');
    Route::post('/usuarios', [ControladorUsuarios::class, 'guardar'])->name('usuarios.guardar');

    Route::get('/roles/crear', [ControladorRoles::class, 'crear'])->name('roles.crear');
    Route::post('/roles', [ControladorRoles::class, 'guardar'])->name('roles.guardar');

    Route::get('/roles/asignar', [ControladorAsignacionRoles::class, 'mostrar'])->name('roles.asignar');
    Route::post('/roles/asignar', [ControladorAsignacionRoles::class, 'asignar'])->name('roles.guardarAsignacion');
});
