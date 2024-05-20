<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Acopio\Donacion;
use App\Models\InventarioAcopio\Articulo;
use App\Models\InventarioAcopio\CapturaArticulo;
use App\Models\InventarioAcopio\SolicitudArticulo;
use App\Models\InventarioReactivos\CapturaReactivo;
use App\Models\InventarioReactivos\DonacionReactivo;
use App\Models\InventarioReactivos\Reactivo;
use App\Models\InventarioReactivos\SolicitudReactivo;
use App\Utils\DateFormats;
use App\Utils\FilterableSortableSearchable;
use App\Utils\TableColumns;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
    use FilterableSortableSearchable;
    use DateFormats;
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

    protected $guarded = [];

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

    protected function nombreCompleto(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) 
                => "{$attributes['nombre']} {$attributes['ap_pat']} {$attributes['ap_mat']}"
        );
    }

    public function reactivosDonados(): BelongsToMany
    {
        return $this->_reactivosDonados()
            ->wherePivotNull('deleted_at');
    }

    public function reactivosDonadosWithTrashed(): BelongsToMany
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




    //REVISAR CREO QUE LA RELACION NO ESTA BIEN DEFINIDA
    public function articulosSolicitados(): BelongsToMany
    {
        return $this->belongsToMany(Articulo::class, 'solicitudes_articulos', 'solicitante_id', 'articulo_id')
            ->as('captura')
            ->withPivot('observaciones', 'condiion')
            ->withTimestamps()
            ->using(User::class);
    }

    // public function articulosCapturados(Type $args): void
    // {
    //     # code...
    // }

    public function solicitantes(): BelongsToMany
    {
        return $this->belongsToMany(SolicitudArticulo::class, 'solicitudes_articulos', 'articulo_id', 'solicitante_id')
            ->as('solicitud')
            ->withPivot('comentario', 'estado')
            ->withTimestamps()
            ->using(SolicitudArticulo::class);
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

    public function productosCapturados(): HasMany
    {
        return $this->hasMany(CapturaArticulo::class);
    }

    public function productosSolicitados(): void
    {
        # code...
    }

    public function donacionesReactivos(): HasMany
    {
        return $this->hasMany(DonacionReactivo::class);
    }

    public function solicitudesServicios(): HasMany
    {
        return $this->hasMany(SolicitudServicio::class);
    }
}
