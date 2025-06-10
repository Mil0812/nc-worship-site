<?php

namespace App\Livewire\SetLists;

use App\Models\Band;
use App\Models\Setlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $bandFilter = '';
    public string $sortDirection = 'desc';

    protected array $queryString = [
        'bandFilter' => ['except' => ''],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingBandFilter(): void
    {
        Log::info('Band filter updated: ' . $this->bandFilter);
        $this->resetPage();
    }

    public function toggleSortDirection(): void
    {
        $this->sortDirection = $this->sortDirection === 'desc' ? 'asc' : 'desc';
        Log::info('Sort direction toggled: ' . $this->sortDirection);
        $this->resetPage();
    }

    public function render()
    {
        if (!Auth::check() || Auth::user()->bands()->count() === 0) {
            Log::warning('No bands for user', ['user_id' => Auth::id() ?? 'guest']);
            return view('livewire.setlists.index', [
                'setlists' => collect(),
                'bands' => collect(),
            ])->with('message', 'Join a band to see setlists.');
        }

        $userBandIds = Auth::user()->bands()->pluck('bands.id')->toArray();
        $bands = Band::whereIn('id', $userBandIds)->orderBy('name')->get();

        $query = Setlist::query()
            ->whereIn('band_id', $userBandIds)
            ->when($this->bandFilter, fn($query) => $query->where('band_id', $this->bandFilter))
            ->with('band')
            ->withCount('songs')
            ->orderBy('performed_at', $this->sortDirection);

        $setlists = $query->paginate(12);

        Log::info('Setlists query executed', [
            'user_id' => Auth::id(),
            'bandFilter' => $this->bandFilter,
            'sortDirection' => $this->sortDirection,
            'setlist_count' => $setlists->count(),
            'total' => $setlists->total(),
            'setlist_names' => $setlists->pluck('name')->toArray(),
        ]);

        return view('livewire.setlists.index', [
            'setlists' => $setlists,
            'bands' => $bands,
        ])->layout('layouts.app', ['title' => 'Setlists']);
    }
}
