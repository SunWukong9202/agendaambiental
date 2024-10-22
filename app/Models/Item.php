<?php

namespace App\Models;

use App\Models\Pivots\ItemMovement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(ItemMovement::class)->as(ItemMovement::PIVOT)
            ->withPivot(ItemMovement::WITH_FIELDS)
            ->withTimestamps();
    }
}
