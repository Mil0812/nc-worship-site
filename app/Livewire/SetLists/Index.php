<?php

namespace App\Livewire\SetLists;

use App\Models\Band;
use App\Models\Setlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

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
        $this->resetPage();
    }

    public function toggleSortDirection(): void
    {
        $this->sortDirection = $this->sortDirection === 'desc' ? 'asc' : 'desc';
        $this->resetPage();
    }

    public function render()
    {
        if (!Auth::check() || Auth::user()->bands()->count() === 0) {
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

        $setlists = $query->paginate(6);

        return view('livewire.setlists.index', [
            'setlists' => $setlists,
            'bands' => $bands,
        ])->layout('layouts.app', ['title' => __('messages.setlists')]);
    }
}
