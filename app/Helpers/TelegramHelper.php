<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramHelper
{
    public static function hasStartedChat(string $telegramId): bool
    {
        try {
            $token = config('services.telegram-bot-api.token');
            $response = Http::get("https://api.telegram.org/bot{$token}/getUpdates", [
                'offset' => -1,
            ]);

            if ($response->successful()) {
                $updates = $response->json('result', []);
                foreach ($updates as $update) {
                    if (isset($update['message']['chat']['id']) && (string)$update['message']['chat']['id'] === $telegramId) {
                        Log::info('Telegram chat confirmed', ['telegram_id' => $telegramId]);
                        return true;
                    }
                }
            }
            Log::info('Telegram chat status check result', [
                'success' => false,
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return false;
        } catch (\Exception $e) {
            Log::error('Failed to check Telegram chat status: ' . $e->getMessage(), [
                'telegram_id' => $telegramId,
                'exception' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    public static function processUpdates(): void
    {
        try {
            $token = config('services.telegram-bot-api.token');
            $response = Http::get("https://api.telegram.org/bot{$token}/getUpdates", [
                'offset' => -1,
            ]);

            if ($response->successful()) {
                $updates = $response->json('result', []);
                foreach ($updates as $update) {
                    if (isset($update['message']['text']) && $update['message']['text'] === '/start') {
                        $chatId = $update['message']['chat']['id'];
                        $username = $update['message']['from']['username'] ?? null;
                        $firstName = $update['message']['from']['first_name'] ?? null;

                        if ($username) {
                            // Update or create user with chat_id based on username
                            $user = User::firstOrCreate(
                                ['telegram_id' => '@' . $username],
                                ['name' => $firstName ?? $username]
                            );
                            $user->update(['telegram_id' => (string)$chatId]);
                            Log::info('Updated telegram_id with chat_id', ['username' => $username, 'chat_id' => $chatId]);
                        } elseif ($firstName) {
                            // Fallback to first_name if username is not available
                            $user = User::where('telegram_id', 'like', '%' . $firstName . '%')->first();
                            if ($user) {
                                $user->update(['telegram_id' => (string)$chatId]);
                                Log::info('Updated telegram_id with chat_id using first_name', ['first_name' => $firstName, 'chat_id' => $chatId]);
                            } else {
                                // Create new user if not found
                                $user = User::create([
                                    'telegram_id' => (string)$chatId,
                                    'name' => $firstName,
                                    'email' => "{$firstName}@example.com",
                                ]);
                                Log::info('Created new user with chat_id', ['first_name' => $firstName, 'chat_id' => $chatId]);
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to process Telegram updates: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
