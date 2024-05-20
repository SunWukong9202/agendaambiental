<?php

namespace App\Models\Acopio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Entrega extends Pivot
{
    use HasFactory;

    protected $table = 'entregas';

    

}
