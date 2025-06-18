<?php

namespace App\Livewire\Bands;

use App\Models\Band;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortDirection = 'asc';

    protected array $queryString = [
        'search' => ['except' => ''],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function updatingSearch(): void
    {
        $this->search = trim($this->search);
        $this->resetPage();
    }

    public function toggleSortDirection(): void
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function render()
    {
        $query = Band::query()
            ->when($this->search, fn($query) => $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%']))
            ->orderBy('name', $this->sortDirection);

        $bands = $query->paginate(6);

        return view('livewire.bands.index', [
            'bands' => $bands,
        ])->layout('layouts.app', ['title' => __('messages.bands')]);
    }
}
