<?php

namespace App\Models;

use App\Models\Pivots\Delivery;
use App\Models\Pivots\Donation;
use App\Models\Pivots\ReagentMovement;
use App\Utils\FilterableSortableSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;
    use FilterableSortableSearchable;

    protected $guarded = [];

    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
    
    //SECTION FOR DELIVERIES TO SUPPLIERS
    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class)
            ->using(Delivery::class)
            ->as(Delivery::PIVOT)->withPivot(Delivery::WITH_FIELDS)
            ->withTimestamps();
    }

    //SECTION: DONTATIONS IN EVENTS AND EVENT CREATION
    public function cmUser(): BelongsTo//creator
    {
        return $this->belongsTo(CMUser::class);
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

    private function _users($as = 'cm_user_id'): BelongsToMany
    {
        return $this->belongsToMany(CMUser::class, Donation::TABLE, relatedPivotKey: $as)
            ->using(Donation::class)
            ->as(Donation::PIVOT)
            ->withPivot(Donation::WITH_FIELDS)
            ->withTimestamps();
    }
}
