<?php

namespace App\Models\Acopio;

use App\Models\Evento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AcopioPorCategoria extends Model
{
    use HasFactory;

    protected $table = 'acopios_por_categorias';

    public function acopio(): BelongsTo
    {
        //FK = methodName_id, PK = id
        return $this->belongsTo(Evento::class);
    }

    public function residuo(): BelongsTo
    {
        //FK = methodName_id = residuo_id, pk = id
        return $this->belongsTo(Residuo::class);
    }

    public function proveedores(): BelongsToMany
    {
        return $this->belongsToMany(Proveedor::class, 'entregas', 'categoria_id', 'proveedor_id')
            ->as('entregas')
            ->withPivot('cantidad')
            ->withTimestamps();
    }
}
