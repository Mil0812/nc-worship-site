<?php

namespace App\Livewire\Songs;

use App\Enums\SongType;
use App\Models\Song;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $typeFilter = '';
    public string $sortBy = 'name';
    public string $sortDirection = 'asc';

    protected array $queryString = [
        'search' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'sortBy' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function updatingSearch(): void
    {
        $this->search = trim($this->search);
        $this->resetPage();
    }

    public function updatingTypeFilter(): void
    {
        $this->resetPage();
    }

    public function toggleSortDirection(): void
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function sort(string $sortBy): void
    {
        if ($this->sortBy === $sortBy) {
            $this->toggleSortDirection();
        } else {
            $this->sortBy = $sortBy;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $query = Song::query()
            ->when($this->search, fn($query) => $query->where(function ($q) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%'])
                    ->orWhereRaw('LOWER(author) LIKE ?', ['%' . strtolower($this->search) . '%']);
            }))
            ->when($this->typeFilter, fn($query) => $query->where('type', $this->typeFilter))
            ->orderBy($this->sortBy === 'popularity' ? 'name' : $this->sortBy, $this->sortDirection);

        $songs = $query->paginate(12);


        return view('livewire.songs.index', [
            'songs' => $songs,
            'songTypes' => SongType::cases(),
        ])->layout('layouts.app', ['title' => __('messages.songs')]);
    }
}
