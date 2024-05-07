<?php

namespace App\Models\InventarioReactivos;

use App\Models\User;
use App\Utils\DateFormats;
use App\Utils\FilterableSortableSearchable;
use App\Utils\TableColumns;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reactivo extends Model
{
    use HasFactory, TableColumns;
    use SoftDeletes;
    use DateFormats;
    use FilterableSortableSearchable;

    public $searchable = ['nombre', 'grupo'];
    public $sortable = ['nombre', 'grupo', 'total', 'created_at'];

    protected $guarded = [];

    protected $table = 'reactivos';

    public $config = [
        'table' => 'donaciones_reactivos',
        'fk' => 'reactivo_id',
        'related_fk' => 'user_id'
    ];

    public function donadores(): BelongsToMany
    {
        $config = $this->config;
        $columns = $this->getTableColumns(exclude: $config);

        return $this->belongsToMany(User::class, $config['table'], $config['fk'], $config['related_fk'])
            ->as('donacion')
            ->withPivot(...$columns)
            ->withTimestamps()
            ->using(DonacionReactivo::class);
    }

    public function solicitantes(): BelongsToMany
    {
        $config = [
            'table' => 'solicitudes_reactivos',
            'fk' => 'reactivo_id',
            'related_fk' => 'user_id'
        ];

        $columns = $this->getTableColumns(exclude: $config);

        return $this->belongsToMany(User::class, $config['table'], $config['fk'], $config['related_fk'])
            ->as('solicitud')
            ->withPivot(...$columns)
            ->withTimestamps()
            ->using(SolicitudReactivo::class);
    }

    public function solicitudes(): HasMany
    {
        return $this->hasMany(SolicitudReactivo::class, 'reactivo_id', 'id');
    }
    
}

    // public function solcitudes(): HasMany
    // {
    //     return $this->hasMany(SolicitudReactivo::class);
    // }

    // public function capturas(): HasMany
    // {
    //     return $this->hasMany(CapturaReactivo::class);
    // }
