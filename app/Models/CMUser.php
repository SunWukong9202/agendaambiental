<?php

namespace App\Models;

use App\Enums\EloquentRelation;
use App\Enums\Movement;
use App\Models\Pivots\Delivery;
use App\Models\Pivots\Donation;
use App\Models\Pivots\ItemMovement;
use App\Models\Pivots\ReagentMovement;
use App\Models\Pivots\Report;
use App\Utils\FilterableSortableSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

use Spatie\Permission\Traits\HasRoles;

class CMUser extends Model implements AuthorizableContract
{
    use Authorizable;
    use HasFactory;
    use SoftDeletes;
    use HasRoles;
    use FilterableSortableSearchable;

    protected $table = 'cm_users';
    protected $guard_name = 'web';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($user) {
            unset($user->role); // Remove from the update attributes
        });
    }
    

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class, 'donator_id');
    }

    public function hasItems(): HasMany 
    {
        return $this->hasMany(Item::class, 'cm_user_id');
    }

    public function itemMovements(): HasMany
    {
        return $this->hasMany(ItemMovement::class, 'cm_user_id');
    }

    public function repairments()
    {
        return $this->hasMany(ItemMovement::class, 'related_id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'cm_user_id');
    }

    public static function searchDonatorsByTerm($searchTerm)
    {
        return self::whereHas('donations')
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('email', 'like', '%' . $searchTerm . '%');
                    });
            })
            ->with('user:id,name,email');
    }

    public function scopeSearchWith($query, $relation, $term, $field) 
    {
    
        $query = match ($relation) {
            'user' => $query->whereHas($relation, function ($relationQuery) use ($term, $field) {
                $relationQuery->where($field, 'like', '%' . $term . '%');
            }),
            default => $query, // Optionally handle other relations here
        };
    
        return $query->with([$relation]);
    }

    public static function searchInRelation($relation, $term) {
        
        $query = CMUser::query();

        if($relation == 'user') {
            $query->whereHas('user', function ($query) use ($term) {
                $query->where('name', 'like', '%' . $term . '%');
            });
        }

        return $query->with(['user']);
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

    private function _events($fk = 'cm_user_id'): BelongsToMany
    {
        return $this->belongsToMany(Event::class, Donation::TABLE ,foreignPivotKey: $fk)
            ->using(Donation::class)
            ->as(Donation::PIVOT)
            ->withPivot(Donation::WITH_FIELDS)
            ->withTimestamps();
    }

    private function _items($fk = 'cm_user_id'): BelongsToMany
    {
        return $this->belongsToMany(Item::class, foreignPivotKey: $fk)
            ->using(ItemMovement::class)->as('movement')
            ->withPivot(ItemMovement::WITH_FIELDS)
            ->withTimestamps();
    }

}
