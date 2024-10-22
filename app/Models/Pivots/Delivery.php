<?php

namespace App\Models\Pivots;

use App\Models\User;
use App\Models\Waste;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Delivery extends Pivot
{
    use HasFactory;

    public const WITH_FIELDS = [
        'quantity', 'user_id', 'waste_id'
    ];
    public const PIVOT = 'delivery';

    protected $table = 'event_supplier';

    public function waste(): BelongsTo
    {
        return $this->belongsTo(Waste::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
