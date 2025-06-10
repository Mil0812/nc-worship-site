<?php

namespace App\Notifications;

use App\Models\SetList;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

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
        return ['database'];
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
}
