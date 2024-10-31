<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Movement;
use App\Models\Pivots\Delivery;
use App\Models\Pivots\Donation;
use App\Models\Pivots\ItemMovement;
use App\Models\Pivots\ReagentMovement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    use HasRoles;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($user) {
            unset($user->role); // Remove from the update attributes
        });
    }

    //SECTION FOR USER REAGENT MOVEMENTS AND REAGENTS
    public function reagents(): BelongsToMany
    {
        return $this->belongsToMany(Reagent::class)
            ->using(ReagentMovement::class)->as(ReagentMovement::PIVOT)
            ->withPivot(ReagentMovement::WITH_FIELDS)
            ->withTimestamps();
    }   

    public function reagentMovements(Movement $movement = Movement::Petition_By_Name): HasMany
    {
        return $this->hasMany(ReagentMovement::class)->where('type', $movement);
    }

    //SECTION FOR USER ITEM MOVEMENT AND ITEMS
    public function items(): BelongsToMany
    {
        return $this->_items();
    }

    public function itemMovements(Movement $movement = Movement::Petition_By_Name): HasMany
    {
        return $this->hasMany(ItemMovement::class)->where('type', $movement);
    }

    //SECTION FOR DELIVERIES HANDLING
    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }

    //SECTION: DONATIONS IN EVENTS AND EVENT CREATION
    public function createdEvents(): HasMany
    {
        return $this->hasMany(Event::class);
    }
    
    public function events(string $for = 'capturist' /** capturist|donator */): BelongsToMany
    {
        return match($for) {
            'capturist' => $this->_events(),
            'donator' => $this->_events('donator_id')
        };
    }

    private function _events($fk = 'user_id'): BelongsToMany
    {
        return $this->belongsToMany(Event::class, foreignPivotKey: $fk)
            ->using(Donation::class)
            ->as(Donation::PIVOT)
            ->withPivot(Donation::WITH_FIELDS)
            ->withTimestamps();
    }

    private function _items($fk = 'user_id'): BelongsToMany
    {
        return $this->belongsToMany(Item::class, foreignPivotKey: $fk)
            ->using(ItemMovement::class)->as('movement')
            ->withPivot(ItemMovement::WITH_FIELDS)
            ->withTimestamps();
    }
}
