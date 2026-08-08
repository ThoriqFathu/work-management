<?php

namespace App\Services\ActivityLog;

use App\Models\ActivityLog;
use App\Services\ActivityLog\Formatters\CreatedFormatter;
use App\Services\ActivityLog\Formatters\DefaultFormatter;
use App\Services\ActivityLog\Formatters\DeletedFormatter;
use App\Services\ActivityLog\Formatters\OutputCreatedFormatter;
use App\Services\ActivityLog\Formatters\OutputDeletedFormatter;
use App\Services\ActivityLog\Formatters\SessionStartedFormatter;
use App\Services\ActivityLog\Formatters\SessionStoppedFormatter;
use App\Services\ActivityLog\Formatters\StatusChangedFormatter;
use App\Services\ActivityLog\Formatters\UpdatedFormatter;

class ActivityLogFormatter
{
    public function __construct(

        protected CreatedFormatter $created,

        protected UpdatedFormatter $updated,

        protected DeletedFormatter $deleted,

        protected StatusChangedFormatter $statusChanged,

        protected SessionStartedFormatter $sessionStarted,

        protected SessionStoppedFormatter $sessionStopped,

        protected OutputCreatedFormatter $outputCreated,

        protected OutputDeletedFormatter $outputDeleted,

        protected DefaultFormatter $default,

    ) {
    }

    public function format(
        ActivityLog $activity
    ): array {

        $formatter = match ($activity->aksi) {

            'created' => $this->created,

            'updated' => $this->updated,

            'deleted' => $this->deleted,

            'status_changed' => $this->statusChanged,

            'session_started' => $this->sessionStarted,

            'session_stopped' => $this->sessionStopped,

            'output_created' => $this->outputCreated,

            'output_deleted' => $this->outputDeleted,

            default => $this->default,

        };

        return [

            ...$formatter->format($activity),

            'user' => $activity->user,

            'created_at' => $activity->created_at,

        ];
    }
}