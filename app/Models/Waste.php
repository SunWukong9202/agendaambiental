<?php

namespace App\Models;

use App\Enums\Units;
use App\Utils\DateFormats;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
    use HasFactory;
    use DateFormats;
    
    protected $guarded = [];
    // protected $casts = [
    //     'unit' => Units::class,
    // ];
}
