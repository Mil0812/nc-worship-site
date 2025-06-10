<?php

namespace App\Notifications;

use App\Models\Band;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

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
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => __('messages.user_added_to_band_title'),
            'message' => str_replace('{band_name}', $this->band->name, __('messages.user_added_to_band_message')),
        ];
    }
}
