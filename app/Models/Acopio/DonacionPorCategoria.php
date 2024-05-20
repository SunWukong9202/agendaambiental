<?php

namespace App\Models\Acopio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DonacionPorCategoria extends Model
{
    use HasFactory;

    protected $table = 'donaciones_por_categorias';

    public function donacion(): BelongsTo
    {
        //por defecto se busca por la FK methodName_id
        //eso es donacion_id, PK = id por defecto
        return $this->belongsTo(Donacion::class);
    }

    public function residuo(): HasOne
    {
        //por defecto FK parentModelName_id
        //eso es 
        return $this->hasOne(Residuo::class, 'id', 'residuo_id');
    }
}
