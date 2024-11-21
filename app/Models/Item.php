<?php

namespace App\Models;

use App\Models\Pivots\ItemMovement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(CMUser::class)
            ->using(ItemMovement::class)->as(ItemMovement::PIVOT)
            ->withPivot(ItemMovement::WITH_FIELDS)
            ->withTimestamps();
    }

    public function movements(): HasMany
    {
        return $this->hasMany(ItemMovement::class);
    }

    public function cmUser(): BelongsTo
    {
        return $this->belongsTo(CMUser::class, 'cm_user_id');
    }
}
