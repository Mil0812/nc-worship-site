<?php

namespace App\Livewire\Bands;

use App\Models\Band;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Show extends Component
{
    public Band $band;

    public function mount($id): void
    {
        $this->band = Band::query()
            ->with(['users.instruments'])
            ->findOrFail($id);

        Log::info('Band details loaded', [
            'band_id' => $this->band->id,
            'band_name' => $this->band->name,
            'member_count' => $this->band->users->count(),
        ]);
    }

    public function render()
    {
        return view('livewire.bands.show')
            ->layout('layouts.app', ['title' => $this->band->name]);
    }
}
