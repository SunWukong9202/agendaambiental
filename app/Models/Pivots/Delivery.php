<?php

namespace App\Models\Pivots;

use App\Models\CMUser;
use App\Models\Event;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Waste;
use App\Utils\FilterableSortableSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Delivery extends Pivot
{
    use HasFactory;
    use FilterableSortableSearchable;

    //quantity, waste_id,cm_user_id,supplier_id,event_id
    public const WITH_FIELDS = [
        'id', 'quantity', 'cm_user_id', 'waste_id', 'supplier_id', 'event_id'
    ];
    public const PIVOT = 'delivery';

    protected $table = 'event_supplier';

    public function waste(): BelongsTo
    {
        return $this->belongsTo(Waste::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(CMUser::class);
    }
    
    public static function searchByPivot($term, $relationships = null)
    {
        $query = self::query();
        // [
        //     'waste|term' => ['category'],
        // ]        
        if(!$relationships) return $query;

        foreach($relationships as $relationship => $searchables) {
            $query->whereHas($relationship, function ($query) use ($searchables, $term) {
                $query->search($term, $searchables);
            });
        }

        return $query->with(collect($relationships)->keys()->toArray());
    }

    // if ($term) {
    //     $query->whereHas('waste', function ($query) use ($term) {
    //         $query->where('category', 'like', '%' . $term . '%');
    //     });
    // }

    // if ($term) {
    //     $query->whereHas('event', function ($query) use ($term) {
    //         $query->where('name', 'like', '%' . $term . '%');
    //     });
    // }

    // if ($term) {
    //     $query->whereHas('supplier', function ($query) use ($term) {
    //         $query->where('name', 'like', '%' . $term . '%');
    //     });
    // }

}
