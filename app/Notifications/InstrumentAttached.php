<?php

namespace App\Notifications;

use App\Models\Instrument;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

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
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => __('messages.instrument_attached_title'),
            'message' => str_replace('{name}', $this->instrument->name, __('messages.instrument_attached_message')),
        ];
    }
}
