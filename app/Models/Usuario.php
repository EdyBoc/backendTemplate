<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';

    public const CREATED_AT = 'creadoEn';
    public const UPDATED_AT = 'actualizadoEn';

    protected $fillable = [
        'nombre',
        'correoElectronico',
        'clave',
        'cambiarClave',
        'dobleFactorHabilitado',
        'dobleFactorSecreto',
    ];

    protected $hidden = [
        'clave',
        'dobleFactorSecreto',
    ];

    protected function casts(): array
    {
        return [
            'cambiarClave' => 'boolean',
            'dobleFactorHabilitado' => 'boolean',
        ];
    }

    public function getAuthPasswordName(): string
    {
        return 'clave';
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Rol::class, 'rolUsuario', 'usuarioId', 'rolId');
    }
}
