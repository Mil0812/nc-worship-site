<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class VerifyTelegramSetup extends Command
{
    protected $signature = 'telegram:verify';
    protected $description = 'Verify Telegram bot setup';

    public function handle(): int
    {
        $token = config('services.telegram-bot-api.token');

        if (!$token) {
            $this->error('TELEGRAM_BOT_TOKEN is not set in your .env file');
            return 1;
        }

        try {
            $response = Http::get("https://api.telegram.org/bot{$token}/getMe");

            if ($response->successful()) {
                $botInfo = $response->json('result');
                $this->info("✅ Bot connection successful!");
                $this->info("Bot name: " . $botInfo['first_name']);
                $this->info("Bot username: @" . $botInfo['username']);


                $webhookResponse = Http::get("https://api.telegram.org/bot{$token}/getWebhookInfo");
                if ($webhookResponse->successful()) {
                    $webhookInfo = $webhookResponse->json('result');
                    if (!empty($webhookInfo['url'])) {
                        $this->info("Webhook URL: " . $webhookInfo['url']);
                    } else {
                        $this->warn("No webhook set. Bot is using getUpdates polling method.");
                        $this->info("To set a webhook, you can use:");
                        $this->info("curl -F \"url=https://your-domain.com/api/telegram/webhook\" https://api.telegram.org/bot{$token}/setWebhook");
                    }
                }

                return 0;
            } else {
                $this->error("❌ Failed to connect to Telegram API: " . $response->body());
                return 1;
            }
        } catch (\Exception $e) {
            $this->error("❌ Exception: " . $e->getMessage());
            return 1;
        }
    }
}
