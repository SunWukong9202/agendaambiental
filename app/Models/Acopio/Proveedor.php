<?php

namespace App\Models\Acopio;

use App\Utils\DateFormats;
use App\Utils\FilterableSortableSearchable;
use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Proveedor extends Model
{
    use HasFactory, DateFormats, FilterableSortableSearchable;

    protected $table = 'proveedores';

    protected $guarded = [];

    public function acopiosPorCategorias(): BelongsToMany
    {
        return $this->belongsToMany(AcopioPorCategoria::class, 'entregas', 'proveedor_id', 'categoria_id')
            ->as('entregas')
            ->withPivot('cantidad')
            ->withTimestamps();
    }

    // protected function colonia(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => Str::title($value),
    //     );
    // }

    public function direccion(): string
    {
        $direccion = "{$this->calle} #{$this->num_ext}";
        if (!empty($this->num_int)) {
            $direccion .= " Int. {$this->num_int}";
        }
        $direccion .= ", {$this->colonia}, {$this->municipio}, {$this->estado}, {$this->cp}";
        return $direccion;
    }
}
