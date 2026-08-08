<?php

namespace App\Models;

use App\Models\Concerns\HasActivityLogs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class WorkSessionOutput extends Model
{
    use SoftDeletes;
    use HasActivityLogs;

    protected $fillable = [

        'work_session_id',

        'tipe',

        'nama',

        'url',

        'storage_path',

        'original_filename',

        'mime_type',

        'size',

        'content',

        'catatan',

        'urutan',

    ];

    protected $casts = [

        'size' => 'integer',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function workSession(): BelongsTo
    {
        return $this->belongsTo(
            WorkSession::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isFile(): bool
    {
        return $this->tipe === 'file';
    }

    public function isLink(): bool
    {
        return $this->tipe === 'link';
    }

    public function isText(): bool
    {
        return $this->tipe === 'text';
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    protected function humanSize(): Attribute
    {
        return Attribute::make(

            get: fn () => $this->formatBytes(
                $this->size
            ),

        );
    }

    protected function fileUrl(): Attribute
    {
        return Attribute::make(

            get: fn () => $this->storage_path
                ? Storage::disk('public')->url(
                    $this->storage_path
                )
                : null,

        );
    }

    protected function displayValue(): Attribute
    {
        return Attribute::make(

            get: function () {

                if ($this->isFile()) {
                    return $this->original_filename;
                }

                if ($this->isLink()) {
                    return $this->url;
                }

                return $this->content;
            }

        );
    }

    /*
    |--------------------------------------------------------------------------
    | Private
    |--------------------------------------------------------------------------
    */

    private function formatBytes(
        ?int $bytes
    ): ?string {

        if (!$bytes) {
            return null;
        }

        $units = [
            'B',
            'KB',
            'MB',
            'GB',
            'TB',
        ];

        $power = floor(
            log($bytes, 1024)
        );

        return number_format(
            $bytes / (1024 ** $power),
            2
        ) . ' ' . $units[$power];
    }
}