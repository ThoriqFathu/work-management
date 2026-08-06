<?php

namespace App\Models;

use App\Models\Concerns\HasActivityLogs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkSessionOutput extends Model
{
    use HasActivityLogs;
    
    protected $fillable = [

        'work_session_id',

        'tipe',

        'nama',

        'value',

        'catatan',

        'urutan',

    ];

    public function workSession(): BelongsTo
    {
        return $this->belongsTo(WorkSession::class);
    }
}