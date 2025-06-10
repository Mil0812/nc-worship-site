<?php

namespace App\Livewire\SetLists;

use App\Models\Setlist;
use App\Models\SetListSong;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Show extends Component
{
    public Setlist $setlist;
    public string $sortDirection = 'asc';
    public ?string $currentlyPlayingPadId = null;

    public function mount($setList): void
    {
        $this->setlist = Setlist::with('band')->findOrFail($setList);
    }

    public function toggleSortDirection(): void
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function playPad($padId): void
    {
        try {
            $this->currentlyPlayingPadId = $padId;
            $this->dispatch('play-pad', padId: $padId);
        } catch (Exception $e) {
            $this->dispatch('showError', message: 'Error playing pad: ' . $e->getMessage());
        }
    }

    public function stopPad(): void
    {
        $this->currentlyPlayingPadId = null;
        $this->dispatch('stop-pad');
    }

    public function render()
    {
        if (!Auth::check() || !$this->setlist->band->users->contains(Auth::user())) {
            abort(403, __('You do not have permission to view this set-list.'));
        }

        $songs = SetListSong::where('set_list_id', $this->setlist->id)
            ->with(['song', 'leader', 'pad'])
            ->orderBy('number', $this->sortDirection)
            ->get();


        return view('livewire.setlists.show', [
            'songs' => $songs,
        ])->layout('layouts.app', ['title' => $this->setlist->name]);
    }
}
