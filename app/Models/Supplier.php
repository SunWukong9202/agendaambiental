<?php

namespace App\Models;

use App\Models\Pivots\Delivery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded = [];
    // //SECTION FOR EVENT DELIVERIES TO SUPPLIERS
    // public function events(): BelongsToMany
    // {
    //     return $this->belongsToMany(Event::class)
    //         ->using(Delivery::class)
    //         ->as(Delivery::PIVOT)
    //         ->withPivot(Delivery::WITH_FIELDS)
    //         ->withTimestamps();
    // }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
