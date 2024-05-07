<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Acopio\Donacion;
use App\Models\InventarioAcopio\CapturaProducto;
use App\Models\InventarioReactivos\CapturaReactivo;
use App\Models\InventarioReactivos\DonacionReactivo;
use App\Models\InventarioReactivos\Reactivo;
use App\Models\InventarioReactivos\SolicitudReactivo;
use App\Utils\TableColumns;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use TableColumns;
    use SoftDeletes;
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

    public function reactivosDonados(): BelongsToMany
    {
        return $this->_reactivosDonados()
            ->wherePivotNull('deleted_at');
    }

    public function reactivosCapturadosWithTrashed(): BelongsToMany
    {
        return $this->_reactivosDonados()
            ->wherePivotNotNull('deleted_at');
    }

    public function reactivosSolicitados(): BelongsToMany
    {
        return $this->_reactivosSolicitados()
        ->wherePivotNull('deleted_at');
    }

    public function reactivosSolicitadosWithTrashed(): BelongsToMany
    {
        return $this->_reactivosSolicitados()
            ->wherePivotNotNull('deleted_at');
    }
                
    private function _reactivosDonados(): BelongsToMany
    {
        $config = [
            'table' => 'donaciones_reactivos',
            'fk' => 'user_id',
            'related_fk' => 'reactivo_id'
        ];
        

        $columns = $this->getTableColumns(exclude: $config);

        return $this->belongsToMany(Reactivo::class, $config['table'], $config['fk'], $config['related_fk'])
            ->as('donacion')
            ->withPivot(...$columns)
            ->withTimestamps()
            ->using(DonacionReactivo::class);
    }

    public function _reactivosSolicitados(): BelongsToMany
    {
        $config = [
            'table' => 'solicitudes_reactivos',
            'fk' => 'user_id',
            'related_fk' => 'reactivo_id'
        ];

        $columns = $this->getTableColumns(exclude: $config);
        
        return $this->belongsToMany(Reactivo::class, $config['table'], $config['fk'], $config['related_fk'])
            ->as('solicitud')
            ->withPivot(...$columns)
            ->withTimestamps()
            ->using(SolicitudReactivo::class);
    }

    public function acopios()
    {
        return $this->belongsToMany(Evento::class, 'donaciones', 'donador_id', 'acopio_id')
                    ->withTimestamps();
    }

    public function solicitudesOtroReactivo() : HasMany
    {
        return $this->hasMany(SolicitudReactivo::class, 'user_id');
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
        return $this->hasMany(DonacionReactivo::class);
    }

    public function solicitudesServicios(): HasMany
    {
        return $this->hasMany(SolicitudServicio::class);
    }
}
