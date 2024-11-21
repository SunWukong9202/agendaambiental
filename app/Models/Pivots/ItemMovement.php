<?php

namespace App\Models\Pivots;

use App\Enums\Movement;
use App\Enums\Status;
use App\Models\CMUser;
use App\Models\Item;
use App\Models\User;
use App\Utils\DateFormats;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemMovement extends Pivot
{
    use HasFactory;
    use DateFormats;

    public const WITH_FIELDS = [
        'type', 'status', 'quantity', 'group_id', 'cm_user_id',
        'item_id', 'related_id'
    ];

    public const PIVOT = 'movement';

    protected $table = 'cm_user_item';
    public $incrementing = true;

    protected $casts = [
        'type' => Movement::class,
        'status' => Status::class,
    ];

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(CMUser::class, 'cm_user_id');
    }

    public function related()
    {
        return $this->belongsTo(CMUser::class, 'related_id');
    }

    public function group(Movement | Status | null $param = null)
    {
        $query = self::where('group_id', $this->group_id);

        if(!isset($param)) {
            return $query;
        }

        return $param instanceof Movement
            ? $query->where('type', $param)
            : $query->where('status', $param);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}   
