<?php

namespace App\Services\ActivityLog;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ActivityLogService
{
    public function log(
        Model $subject,
        string $action,
        ?string $description = null,
        ?array $old = null,
        ?array $new = null,
        ?User $user = null,
    ): ActivityLog {

        $user ??= auth()->user();

        return $subject->activityLogs()->create([

            'user_id' => $user?->id,

            'aksi' => $action,

            'deskripsi' => $description,

            'data_lama' => $old,

            'data_baru' => $new,

        ]);

    }
}