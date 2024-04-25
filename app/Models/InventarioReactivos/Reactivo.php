<?php

namespace App\Models\InventarioReactivos;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reactivo extends Model
{
    use HasFactory;

    protected $guard = [
        'visible',// <= protegido contra asignacion masiva
    ];

    protected $table = 'reactivos';

    public function capturistas(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'captura_reactivos', 'reactivo_id', 'responsable_id')
            ->as('captura')
            ->withTimestamps();
    }

    public function solicitantes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'solicitud_reactivos', 'reactivo_id', 'user_id')
            ->as('solicitud')
            ->withTimestamps();
    }

    // public function solcitudes(): HasMany
    // {
    //     return $this->hasMany(SolicitudReactivo::class);
    // }

    // public function capturas(): HasMany
    // {
    //     return $this->hasMany(CapturaReactivo::class);
    // }
}
