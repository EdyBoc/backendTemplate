<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rol extends Model
{
    protected $table = 'roles';

    public const CREATED_AT = 'creadoEn';
    public const UPDATED_AT = 'actualizadoEn';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(Usuario::class, 'rolUsuario', 'rolId', 'usuarioId');
    }
}
