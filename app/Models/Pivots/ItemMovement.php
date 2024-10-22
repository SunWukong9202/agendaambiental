<?php

namespace App\Models\Pivots;

use App\Enums\Movement;
use App\Enums\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemMovement extends Pivot
{
    use HasFactory;

    public const WITH_FIELDS = [
        'type', 'status', 'quantity', 'group_id'
    ];
    public const PIVOT = 'movement';

    protected $table = 'item_user';
    public $incrementing = true;

    protected $casts = [
        'type' => Movement::class,
        'status' => Status::class,
    ];

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}   
