<?php

namespace App\Notifications;

use App\Helpers\TelegramHelper;
use App\Models\Band;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\TelegramMessage;

class UserAddedToBand extends Notification
{
    use Queueable;

    public $band;

    public function __construct(Band $band)
    {
        $this->band = $band;
    }

    public function via($notifiable): array
    {
        if (!$notifiable->receive_notifications) {
            Log::info('User has notifications disabled', ['user_id' => $notifiable->id]);
            return [];
        }
        $channels = ['database'];

        if ($notifiable->telegram_id) {
            $hasStartedChat = TelegramHelper::hasStartedChat($notifiable->telegram_id);
            Log::info('Checking if user has started Telegram chat', [
                'user_id' => $notifiable->id,
                'telegram_id' => $notifiable->telegram_id,
                'has_started_chat' => $hasStartedChat
            ]);

            if ($hasStartedChat) {
                $channels[] = 'telegram';
            }
        } else {
            Log::info('User has no Telegram ID', ['user_id' => $notifiable->id]);
        }

        Log::info('Notification channels', ['channels' => $channels, 'user_id' => $notifiable->id]);
        return $channels;
    }



    public function toTelegram($notifiable): TelegramMessage
    {
        try {
            $message = str_replace('{band_name}', $this->band->name, __('messages.user_added_to_band_message'));

            return TelegramMessage::create()
                ->to($this->getCleanTelegramId($notifiable->telegram_id))
                ->content("👥 *" . __('messages.user_added_to_band_title') . "*\n\n" . $message)
                ->button(__('View Band'), route('bands.show', $this->band->id));
        }
        catch (\Exception $e) {
            Log::error('Failed to send Telegram notification: ' . $e->getMessage(), [
                'user_id' => $notifiable->id,
                'telegram_id' => $notifiable->telegram_id
            ]);

            return TelegramMessage::create()
                ->to($this->getCleanTelegramId($notifiable->telegram_id))
                ->content('Notification');
        }
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => __('messages.user_added_to_band_title'),
            'message' => str_replace('{band_name}', $this->band->name, __('messages.user_added_to_band_message')),
        ];
    }

    private function getCleanTelegramId($telegramId): string
    {
        return ltrim($telegramId, '@');
    }
}
