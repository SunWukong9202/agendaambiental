<?php

namespace App\Models;

use App\Enums\Units;
use App\Models\Pivots\ReagentMovement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reagent extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'unit' => Units::class,
    ];

    //SECTION FOR USER REAGENT MOVEMENTS AND REAGENTS
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(ReagentMovement::class)
            ->using(ReagentMovement::class)->as(ReagentMovement::PIVOT)
            ->withPivot(ReagentMovement::WITH_FIELDS)
            ->withTimestamps();
    }
}
