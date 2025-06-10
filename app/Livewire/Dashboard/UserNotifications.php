<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

class UserNotifications extends Component
{
    public $notifications;
    public string $search = '';
    public int $unreadCount = 0;

    public function mount(): void
    {
        $this->loadNotifications();
        $this->calculateUnreadCount();
    }

    public function loadNotifications(): void
    {
        $user = Auth::user();
        $query = $user->notifications();

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereRaw("data->>'message' ILIKE ?", ['%' . $this->search . '%'])
                    ->orWhereRaw("data->>'title' ILIKE ?", ['%' . $this->search . '%']);
            });
        }

        $this->notifications = $query->orderBy('created_at', 'desc')
            ->get();
    }

    public function calculateUnreadCount(): void
    {
        $this->unreadCount = Auth::user()->unreadNotifications()->count();
    }

    public function markAsRead(string $notificationId): void
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            $this->loadNotifications();
            $this->calculateUnreadCount();
            $this->dispatch('customShowSuccess', message: 'Notification marked as read.');
        }
    }

    public function updatedSearch(): void
    {
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.dashboard.user-notifications')
            ->layout('layouts.dashboard', ['title' => 'Notifications']);
    }
}
