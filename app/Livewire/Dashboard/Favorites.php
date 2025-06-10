<?php

namespace App\Livewire\Dashboard;

use App\Models\Favourite;
use App\Models\Song;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard', ['title' => 'Favorites'])]
class Favorites extends Component
{
    public $favorites;
    public string $sortBy = 'name';
    public string $sortDirection = 'asc';

    public function mount(): void
    {
        $this->loadFavorites();
    }

    public function loadFavorites(): void
    {
        $user = Auth::user();
        $this->favorites = Favourite::where('user_id', $user->id)
            ->with('song')
            ->get()
            ->pluck('song')
            ->sortBy([
                [$this->sortBy, $this->sortDirection],
            ]);
    }

    public function sort($column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }

        $this->loadFavorites();
    }

    public function removeFromFavorites($songId): void
    {
        $user = Auth::user();
        Favourite::where('user_id', $user->id)
            ->where('song_id', $songId)
            ->delete();

        $this->loadFavorites();
        session()->flash('status', __('messages.song_removed_from_favorites'));
    }

    public function render(): object
    {
        return view('livewire.dashboard.favorites');
    }
}
