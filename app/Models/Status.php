<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    protected $fillable = [
        'nama',
        'warna',
    ];

    public function workRequests(): HasMany
    {
        return $this->hasMany(WorkRequest::class);
    }
}