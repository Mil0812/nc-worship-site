<?php

namespace App\Notifications;

use App\Helpers\TelegramHelper;
use App\Models\Instrument;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\TelegramMessage;

class InstrumentAttached extends Notification
{
    use Queueable;

    public $instrument;

    public function __construct(Instrument $instrument)
    {
        $this->instrument = $instrument;
    }

    public function via($notifiable): array
    {
        if (!$notifiable->receive_notifications) {
            return [];
        }
        $channels = ['database'];

        if ($notifiable->telegram_id && TelegramHelper::hasStartedChat($notifiable->telegram_id)) {
            $channels[] = 'telegram';
        }
        return $channels;
    }

    public function toTelegram($notifiable): TelegramMessage
    {

        try {
            $message = str_replace('{name}', $this->instrument->name, __('messages.instrument_attached_message'));

            return TelegramMessage::create()
                ->to($this->getCleanTelegramId($notifiable->telegram_id))
                ->content("🎸 *" . __('messages.instrument_attached_title') . "*\n\n" . $message);
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
            'title' => __('messages.instrument_attached_title'),
            'message' => str_replace('{name}', $this->instrument->name, __('messages.instrument_attached_message')),
        ];
    }
    private function getCleanTelegramId($telegramId): string
    {
        return ltrim($telegramId, '@');
    }
}
