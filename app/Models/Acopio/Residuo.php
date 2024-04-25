<?php

namespace App\Models\Acopio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Residuo extends Model
{
    use HasFactory;

    protected $table = 'residuos';

    public function residuo(): BelongsTo
    {
        //por defecto FK methodName_id
        //eso seria residuo_id
        return $this->belongsTo(DonacionPorCategoria::class, 'id', 'residuo_id');
    }

    public function acopioPorCategoria(): HasOne
    {
        return $this->hasOne(AcopioPorCategoria::class);
    }
}
