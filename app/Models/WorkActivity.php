<?php

namespace App\Models;

use App\Models\Concerns\HasActivityLogs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkActivity extends Model
{
    use HasActivityLogs;
    
    protected $fillable = [
        'user_id',
        'requester_unit_id',
        'tipe',
        'channel',
        'durasi_menit',
        'ringkasan',
    ];

    protected $casts = [
        'durasi_menit' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function requesterUnit(): BelongsTo
    {
        return $this->belongsTo(
            RequesterUnit::class
        );
    }
}