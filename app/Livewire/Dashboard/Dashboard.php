<?php

namespace App\Livewire\Dashboard;

use App\Models\Band;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

class Dashboard extends Component
{
    use WithFileUploads;

    public $user;
    public $bands;

    #[Validate('nullable|image|max:2048')]
    public $new_avatar;

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->bands = $this->user->bands;
    }

    public function updatedNewAvatar(): void
    {
        $this->validate([
            'new_avatar' => 'nullable|image|max:2048',
        ]);

        if ($this->new_avatar) {
            $this->updateAvatar();
        }
    }

    public function updateAvatar(): void
    {
        if (!$this->new_avatar) {
            $this->dispatch('showError', message: __('No file selected.'));
            return;
        }

        try {
            if ($this->user->avatar) {
                Storage::disk('public')->delete($this->user->avatar);
            }

            $path = $this->new_avatar->store('avatars', 'public');

            $this->user->avatar = $path;
            $this->user->save();

            $this->new_avatar = null;

            $this->dispatch('showSuccess', message: __('Avatar updated successfully.'));

        } catch (Exception $e) {
            $this->dispatch('showError', message: __('Failed to update avatar: ' . $e->getMessage()));
        }
    }

    #[On('removeAvatar')]
    public function removeAvatar(): void
    {
        try {
            if ($this->user->avatar) {
                Storage::disk('public')->delete($this->user->avatar);

                $this->user->avatar = null;
                $this->user->save();

                $this->dispatch('showSuccess', message: __('Avatar removed successfully.'));
            } else {
                $this->dispatch('showError', message: __('No avatar to remove.'));
            }
        } catch (Exception $e) {
            $this->dispatch('showError', message: __('Failed to remove avatar: ') . $e->getMessage());
        }
    }

    public function render(): object
    {
        return view('livewire.dashboard', [
            'user' => $this->user,
            'bands' => $this->bands,
            'new_avatar' => $this->new_avatar,
        ])
            ->layout('layouts.dashboard', ['title' => 'Dashboard']);
    }
}
