<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Priority extends Model
{
    protected $fillable = [
        'nama',
        'urutan',
        'warna',
    ];

    public function workRequests(): HasMany
    {
        return $this->hasMany(WorkRequest::class);
    }
}