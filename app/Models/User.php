<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Acopio\Donacion;
use App\Models\InventarioAcopio\CapturaProducto;
use App\Models\InventarioReactivos\CapturaReactivo;
use App\Models\InventarioReactivos\Reactivo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'clave',
    //     'nombre',
    //     'genero',
    //     'password',
    // ];

    protected $guard = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

                
    public function reactivosCapturados(): BelongsToMany
    {
        return $this->belongsToMany(Reactivo::class, 'captura_reactivos', 'responsable_id', 'reactivo_id')
            ->as('captura')
            ->withTimestamps();
    }

    public function reactivosSolicitados(): BelongsToMany
    {
        return $this->belongsToMany(Reactivo::class, 'solicitud_reactivos', 'user_id', 'reactivo_id')
            ->as('solicitud')
            ->withTimestamps();
    }


    public function acopios()
    {
        return $this->belongsToMany(Evento::class, 'donaciones', 'donador_id', 'acopio_id')
                    ->withTimestamps();
    }

    public function donaciones(): HasMany
    {
        return $this->hasMany(Donacion::class);
    }

    public function donacionesDeLibros(): BelongsToMany
    {
        return $this->donaciones()->where('de_residuos', false);
    }

    public function capturasProductos(): HasMany
    {
        return $this->hasMany(CapturaProducto::class);
    }

    public function capturasReactivos(): HasMany
    {
        return $this->hasMany(CapturaReactivo::class);
    }

    public function solicitudesServicios(): HasMany
    {
        return $this->hasMany(SolicitudServicio::class);
    }
}
