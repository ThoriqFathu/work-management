<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TelegramUser extends Model
{
    protected $fillable = [
        'user_id',
        'telegram_user_id',
        'username',
        'first_name',
        'last_name',
        'is_active',
    ];

    protected $casts = [
        'telegram_user_id' => 'integer',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(
            TelegramChat::class,
            'telegram_chat_user'
        )->withTimestamps();
    }
}