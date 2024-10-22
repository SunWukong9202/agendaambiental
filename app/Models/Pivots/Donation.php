<?php

namespace App\Models\Pivots;

use App\Enums\EventDonation;
use App\Models\User;
use App\Models\Waste;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Donation extends Pivot
{
    use HasFactory;

    public const WITH_FIELDS = [
        'type', 'books_taken', 'books_donated',
        'quantity', 'donator_id', 'user_id', 'waste_id'
    ];
    public const PIVOT = 'donation';

    protected $casts = [
        'type' => EventDonation::class
    ];

    protected $guarded = ['event_id'];

    protected $table = 'event_user';

    public function waste(): BelongsTo
    {
        return $this->belongsTo(Waste::class);
    }

    public function donator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function capturist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
