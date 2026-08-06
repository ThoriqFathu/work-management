<?php

namespace App\Models;

use App\Models\Concerns\HasActivityLogs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkSession extends Model
{
    use HasActivityLogs;

    protected $fillable = [
        'work_request_id',
        'user_id',
        'started_at',
        'ended_at',
        'durasi_menit',
        'catatan',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
    ];

    public function workRequest(): BelongsTo
    {
        return $this->belongsTo(WorkRequest::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function outputs(): HasMany
    {
        return $this->hasMany(
            WorkSessionOutput::class
        )->orderBy('urutan');
    }

}