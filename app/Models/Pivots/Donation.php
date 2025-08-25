<?php

namespace App\Models\Pivots;

use App\Enums\EventDonation;
use App\Models\CMUser;
use App\Models\Event;
use App\Models\User;
use App\Models\Waste;
use App\Utils\DateFormats;
use App\Utils\FilterableSortableSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Donation extends Pivot
{
    use HasFactory;
    use FilterableSortableSearchable;
    use DateFormats;

    public const WITH_FIELDS = [
        'id',
        'type', 'books_taken', 'books_donated',
        'quantity', 'donator_id', 'cm_user_id', 'waste_id'
    ];
    public const PIVOT = 'donation';
    public const TABLE = 'cm_user_event';
    // protected $casts = [
    //     'type' => EventDonation::class
    // ];

    protected $guarded = [];

    protected $table = 'cm_user_event';

    public function event()  
    {
        return $this->belongsTo(Event::class);
    }

    public function donator(): BelongsTo
    {
        return $this->belongsTo(CMUser::class, 'donator_id');
    }

    public function getDonatorName(): string
    {
        $donator = $this->donator;

        if(!$donator->user) {
            return $donator->name;
        }

        return $donator->user->name;
    }

    public function getDonatorDescription(): string
    {
        $donator = $this->donator;

        if(!$donator->user) {
            $type = trans('Extern User');
            return "$type - {$donator->user->email}";
        }
        $type = trans('Intern User');
        return "$type - {$donator->user->email}";
    }

    public function waste(): BelongsTo
    {
        return $this->belongsTo(Waste::class);
    }

    public function capturist(): BelongsTo
    {
        return $this->belongsTo(CMUser::class, 'cm_user_id');
    }
}
