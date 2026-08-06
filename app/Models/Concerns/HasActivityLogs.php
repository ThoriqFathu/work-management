<?php

namespace App\Models\Concerns;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasActivityLogs
{
    public function activityLogs(): MorphMany
    {
        return $this->morphMany(
            ActivityLog::class,
            'subject'
        );
    }

    public function latestActivityLogs(): MorphMany
    {
        return $this->activityLogs()
            ->latest();
    }
}