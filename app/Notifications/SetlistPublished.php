<?php

namespace App\Notifications;

use App\Helpers\TelegramHelper;
use App\Models\SetList;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\TelegramMessage;

class SetlistPublished extends Notification
{
    use Queueable;

    public $setlist;

    public function __construct(SetList $setlist)
    {
        $this->setlist = $setlist;
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
            $message = str_replace(
                ['{setlist_name}', '{band_name}'],
                [$this->setlist->name, $this->setlist->band->name],
                __('messages.setlist_published_message')
            );

            return TelegramMessage::create()
                ->to($this->getCleanTelegramId($notifiable->telegram_id))
                ->content("🎵 *" . __('messages.setlist_published_title') . "*\n\n" . $message)
                ->button(__('view-setlist'), route('setlists.show', $this->setlist->id));
        } catch (\Exception $e) {
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
            'title' => __('messages.setlist_published_title'),
            'message' => str_replace(
                ['{setlist_name}', '{band_name}'],
                [$this->setlist->name, $this->setlist->band->name],
                __('messages.setlist_published_message')
            ),
        ];
    }

    private function getCleanTelegramId($telegramId): string
    {
        return ltrim($telegramId, '@');
    }
}
