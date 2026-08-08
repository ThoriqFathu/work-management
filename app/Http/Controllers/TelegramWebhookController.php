<?php

namespace App\Http\Controllers;

use App\Models\TelegramChat;
use App\Models\TelegramUser;
use App\Services\Telegram\Commands\TelegramCommandRouter;
use App\Services\Telegram\TelegramBotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class TelegramWebhookController extends Controller
{
    public function __invoke(
        Request $request,
        TelegramCommandRouter $router,
        TelegramBotService $telegram,
    ) {
        $update = $request->all();

        $message = $update['message'] ?? null;

        if (! $message) {
            return response()->json([
                'ok' => true,
            ]);
        }

        $chat = $message['chat'] ?? [];
        $from = $message['from'] ?? [];
        $text = $message['text'] ?? '';

        $telegramChatId = $chat['id'] ?? null;
        $telegramUserId = $from['id'] ?? null;

        if (! $telegramChatId || ! $telegramUserId) {
            return response()->json([
                'ok' => true,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Log Identity
        |--------------------------------------------------------------------------
        */

        Log::info('Telegram Identity', [
            'telegram_user_id' => $telegramUserId,
            'username' => $from['username'] ?? null,
            'first_name' => $from['first_name'] ?? null,
            'last_name' => $from['last_name'] ?? null,
            'telegram_chat_id' => $telegramChatId,
            'chat_title' => $chat['title'] ?? null,
            'chat_type' => $chat['type'] ?? null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Whitelist Chat
        |--------------------------------------------------------------------------
        */

        $telegramChat = TelegramChat::query()
            ->where('telegram_chat_id', $telegramChatId)
            ->where('is_active', true)
            ->first();

        if (! $telegramChat) {
            return response()->json([
                'ok' => true,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Whitelist User
        |--------------------------------------------------------------------------
        */

        $telegramUser = TelegramUser::query()
            ->with('user')
            ->where('telegram_user_id', $telegramUserId)
            ->where('is_active', true)
            ->first();

        if (! $telegramUser || ! $telegramUser->user) {
            return response()->json([
                'ok' => true,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Chat Membership
        |--------------------------------------------------------------------------
        */

        $allowed = $telegramChat
            ->users()
            ->where(
                'telegram_users.id',
                $telegramUser->id
            )
            ->exists();

        if (! $allowed) {
            return response()->json([
                'ok' => true,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Command
        |--------------------------------------------------------------------------
        */

        try {

            $response = $router->handle(
                $text,
                $telegramUser,
            );

            if ($response !== null) {
                $telegram->sendMessage(
                    $telegramChatId,
                    $response
                );
            }

        } catch (Throwable $e) {

            report($e);

            $telegram->sendMessage(
                $telegramChatId,
                '❌ Terjadi kesalahan saat memproses command.'
            );
        }

        return response()->json([
            'ok' => true,
        ]);
    }
}