<?php

namespace App\Livewire\Tutorials;

use App\Models\Instrument;
use App\Models\Song;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';
    public string $instrumentFilter = '';

    protected array $queryString = [
        'search' => ['except' => ''],
        'instrumentFilter' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->search = trim($this->search);
    }

    public function updatingInstrumentFilter(): void
    {

    }

    public function render()
    {
        $songs = Song::query()
            ->when($this->search, fn($query) => $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%']))
            ->when($this->instrumentFilter, fn($query) => $query->whereHas('tutorials', fn($q) => $q
                ->where('is_public', true)
                ->whereHas('instrument', fn($q2) => $q2->where('name', $this->instrumentFilter))
            ))
            ->with(['tutorials' => function ($query) {
                $query->where('is_public', true)
                    ->when($this->instrumentFilter, fn($q) => $q->whereHas('instrument', fn($q2) => $q2->where('name', $this->instrumentFilter)))
                    ->with('instrument');
            }])
            ->has('tutorials')
            ->get()
            ->sortBy('name');

        return view('livewire.tutorials.index', [
            'songs' => $songs,
            'instruments' => Instrument::orderBy('name')->get(),
        ])->layout('layouts.app', ['title' => 'Tutorials']);
    }
}
