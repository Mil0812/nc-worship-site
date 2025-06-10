<?php

namespace App\Livewire;

use App\Models\Song;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Home extends Component
{
    public $songs;

    public function mount(): void
    {
        try {
            $this->songs = Song::orderBy('created_at', 'desc')->take(3)->get();
        } catch (Exception $e) {
            $this->songs = collect();
        }
    }

    public function render()
    {
        try {
            return view('livewire.home', [
                'isGroupMember' => true,
            ])->layout('layouts.app');
        } catch (Exception $e) {

            return view('livewire.home', [
                'isGroupMember' => true,
            ])->layout('layouts.app', ['title' => 'Bands']);
        }
    }
}
