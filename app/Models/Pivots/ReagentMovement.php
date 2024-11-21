<?php

namespace App\Models\Pivots;

use App\Enums\ChemicalState;
use App\Enums\Condition;
use App\Enums\CRETIB;
use App\Enums\Movement;
use App\Enums\Status;
use App\Enums\Units;
use App\Models\CMUser;
use App\Models\Reagent;
use App\Models\User;
use App\Utils\DateFormats;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ReagentMovement extends Pivot
{
    use HasFactory;
    use DateFormats;

    public const WITH_FIELDS = [
        'type', 'status', 
        'quantity', 'container', 'photo_url', 'weight',
        'expiration', 'condition', 'proc_fac', 'proc_lab',
        'cretib', 'comment', 'reagent_name', 'cm_user_id', 'reagent_id'
    ];
    public const PIVOT = 'movement';

    protected $table = 'cm_user_reagent';

    protected $casts = [
        'type' => Movement::class,
        'status' => Status::class,
        'cretib' => AsEnumCollection::class.':'.CRETIB::class,
        'condition' => Condition::class,
        'chemical_state' => ChemicalState::class,
        'unit' => Units::class,
    ];

    public function reagent(): BelongsTo
    {
        return $this->belongsTo(Reagent::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(CMUser::class);
    }
}
