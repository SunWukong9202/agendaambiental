<?php

namespace App\Models\Pivots;

use App\Models\CMUser;
use App\Models\Supplier;
use App\Utils\DateFormats;
use Illuminate\Contracts\Mail\Attachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Mail\Attachment;
use Illuminate\Support\Facades\Storage;

class Report extends Model implements Attachable
{
    use HasFactory;
    use DateFormats;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            Storage::disk('public')->delete($model->file_path);
        });
    }

    public function toMailAttachment()
    {
        return Attachment::fromStorageDisk('public', $this->file_path);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(CMUser::class, 'cm_user_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
