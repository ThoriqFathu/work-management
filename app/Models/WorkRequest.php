<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WorkRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode',
        'judul',
        'deskripsi',
        'unit_kerja_id',
        'requester_unit_id',
        'category_id',
        'priority_id',
        'status_id',
        'assigned_to',
        'created_by',
        'request_date',
        'estimasi_menit',
        'aktual_menit',
        'deadline',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'request_date' => 'date',
        'deadline' => 'datetime',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function unitKerja(): BelongsTo
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function requesterUnit(): BelongsTo
    {
        return $this->belongsTo(RequesterUnit::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(Priority::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(TaskLog::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TaskComment::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(TaskFile::class);
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(
            Label::class,
            'task_label'
        );
    }
}