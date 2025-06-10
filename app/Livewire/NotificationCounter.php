<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationCounter extends Component
{
    public int $unreadCount = 0;

    public function mount(): void
    {
        $this->calculateUnreadCount();
    }

    public function calculateUnreadCount(): void
    {
        $this->unreadCount = auth()->check() ? auth()->user()->unreadNotifications()->count() : 0;
    }

    public function render(): object
    {
        return view('livewire.notification-counter');
    }
}
