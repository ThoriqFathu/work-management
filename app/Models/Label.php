<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Label extends Model
{
    protected $fillable = [
        'nama',
        'warna',
    ];

    public function workRequests(): BelongsToMany
    {
        return $this->belongsToMany(
            WorkRequest::class,
            'task_label'
        );
    }
}