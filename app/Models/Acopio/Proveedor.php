<?php

namespace App\Models\Acopio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    public function acopiosPorCategorias(): BelongsToMany
    {
        return $this->belongsToMany(AcopioPorCategoria::class, 'entregas', 'proveedor_id', 'categoria_id')
            ->as('entregas')
            ->withPivot('cantidad')
            ->withTimestamps();
    }
}
