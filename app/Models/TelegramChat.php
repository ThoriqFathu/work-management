<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TelegramChat extends Model
{
    protected $fillable = [
        'telegram_chat_id',
        'title',
        'type',
        'is_active',
    ];

    protected $casts = [
        'telegram_chat_id' => 'integer',
        'is_active' => 'boolean',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            TelegramUser::class,
            'telegram_chat_user'
        )->withTimestamps();
    }
}