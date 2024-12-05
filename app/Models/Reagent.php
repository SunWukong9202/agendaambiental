<?php

namespace App\Models;

use App\Enums\Units;
use App\Models\Pivots\ReagentMovement;
use App\Utils\DateFormats;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reagent extends Model
{
    use HasFactory, DateFormats;

    protected $guarded = [];

    protected $casts = [
        'unit' => Units::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(CMUser::class, 'cm_user_id');
    }

    //SECTION FOR USER REAGENT MOVEMENTS AND REAGENTS
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(ReagentMovement::class)
            ->using(ReagentMovement::class)->as(ReagentMovement::PIVOT)
            ->withPivot(ReagentMovement::WITH_FIELDS)
            ->withTimestamps();
    }
}
