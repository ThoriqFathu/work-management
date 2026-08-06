<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    protected $fillable = [

        'user_id',

        'aksi',

        'deskripsi',

        'data_lama',

        'data_baru',

    ];

    protected $casts = [

        'data_lama' => 'array',

        'data_baru' => 'array',

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }
}