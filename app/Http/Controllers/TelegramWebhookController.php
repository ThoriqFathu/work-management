<?php

namespace App\Http\Controllers;

use App\Models\TelegramChat;
use App\Models\TelegramUser;
use App\Services\Telegram\CreateWorkRequestFromTelegramService;
use App\Services\Telegram\TelegramBotService;
use App\Services\Telegram\TelegramRequestParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class TelegramWebhookController extends Controller
{
    public function __invoke(
        Request $request,
        TelegramRequestParser $parser,
        CreateWorkRequestFromTelegramService $createWorkRequest,
        TelegramBotService $telegram,
    ) {
        $update = $request->all();

        $message = $update['message'] ?? null;

        Log::info('Telegram Identity', [
            'telegram_user_id' => $message['from']['id'] ?? null,
            'username' => $message['from']['username'] ?? null,
            'first_name' => $message['from']['first_name'] ?? null,
            'last_name' => $message['from']['last_name'] ?? null,

            'telegram_chat_id' => $message['chat']['id'] ?? null,
            'chat_title' => $message['chat']['title'] ?? null,
            'chat_type' => $message['chat']['type'] ?? null,
        ]);

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
        | Whitelist User + Laravel User Mapping
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
        | Pastikan User tergabung di Chat
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
        | Hanya proses /req
        |--------------------------------------------------------------------------
        */

        if (! str_starts_with(
            strtolower(trim($text)),
            '/req:'
        )) {
            return response()->json([
                'ok' => true,
            ]);
        }

        try {

            $parsed = $parser->parse($text);

            $workRequests = $createWorkRequest->execute(
                $parsed,
                $telegramUser,
            );

            $lines = [
                '✅ Work Request berhasil dibuat:',
                '',
            ];

            foreach ($workRequests as $workRequest) {
                $lines[] =
                    "{$workRequest->kode} - {$workRequest->judul}";
            }

            $telegram->sendMessage(
                $telegramChatId,
                implode("\n", $lines)
            );

        } catch (Throwable $e) {

            report($e);

            $telegram->sendMessage(
                $telegramChatId,
                "❌ Gagal membuat Work Request.\n\n"
                . $e->getMessage()
            );

            return response()->json([
                'ok' => true,
            ]);
        }

        return response()->json([
            'ok' => true,
        ]);
    }
}