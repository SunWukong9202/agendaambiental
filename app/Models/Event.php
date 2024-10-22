<?php

namespace App\Models;

use App\Models\Pivots\Delivery;
use App\Models\Pivots\Donation;
use App\Models\Pivots\ReagentMovement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];


    // public function reagents(): BelongsToMany
    // {
    //     return $this->belongsToMany(Reagent::class)
    //         ->using(ReagentMovement::class)->as('movement')
    //         ->with
    // }
    
    //SECTION FOR DELIVERIES TO SUPPLIERS
    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class)
            ->using(Delivery::class)
            ->as(Delivery::PIVOT)->withPivot(Delivery::WITH_FIELDS)
            ->withTimestamps();
    }

    //SECTION: DONTATIONS IN EVENTS AND EVENT CREATION
    public function user(): BelongsTo//creator
    {
        return $this->belongsTo(User::class);
    }

    public function users($as = 'capturist' /**capturists|donators*/): BelongsToMany
    {
        return match($as) {
            //want to attach donations to donators and see donators
            'capturist' => $this->_users('donator_id'),
            //want to attach and see capturists
            //although only see capturists will be allowed
            'donator' => $this->_users(),
            //by default we will always retrieve/attach capturists
            default => $this->_users()
        };
    }

    private function _users($as = 'user_id'): BelongsToMany
    {
        return $this->belongsToMany(User::class, relatedPivotKey: $as)
            ->using(Donation::class)
            ->as(Donation::PIVOT)
            ->withPivot(Donation::WITH_FIELDS)
            ->withTimestamps();
    }
}
