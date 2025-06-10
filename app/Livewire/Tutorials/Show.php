<?php

namespace App\Livewire\Tutorials;

use App\Models\Comment;
use App\Models\Tutorial;
use App\HasComments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Show extends Component
{
    use HasComments;

    public string $slug;
    public Tutorial $selectedTutorial;
    public array $tutorials;


    public function mount(string $slug): void
    {
        $this->slug = $slug;
        $this->selectedTutorial = Tutorial::query()
            ->where('slug', $slug)
            ->where('is_public', true)
            ->with(['song', 'instrument'])
            ->firstOrFail();

        $this->tutorials = Tutorial::query()
            ->where('song_id', $this->selectedTutorial->song_id)
            ->where('is_public', true)
            ->with('instrument')
            ->get()
            ->map(function ($tutorial) {
                $instrument = $tutorial->instrument;
                if (!$instrument) {
                    Log::warning('Tutorial missing instrument', [
                        'tutorial_id' => $tutorial->id,
                        'slug' => $tutorial->slug,
                        'song_id' => $tutorial->song_id,
                    ]);
                }
                return [
                    'id' => $tutorial->id,
                    'slug' => $tutorial->slug,
                    'instrument_name' => $instrument?->name ?? 'Unknown',
                    'icon' => $instrument?->icon ?? asset('default-images/example-musical-instrument.png'),
                    'video' => $tutorial->video,
                    'description' => $tutorial->description,
                ];
            })
            ->toArray();
    }

    public function selectTutorial(string $slug): void
    {
        $this->slug = $slug;
        $this->selectedTutorial = Tutorial::query()
            ->where('slug', $slug)
            ->where('is_public', true)
            ->with(['song', 'instrument'])
            ->firstOrFail();

        $this->redirect(route('tutorials.show', $slug), navigate: true);

        $this->dispatch('update-video', url: $this->selectedTutorial->video);
    }

    protected function getCommentableId(): string
    {
        return $this->selectedTutorial->id;
    }

    protected function getCommentableType(): string
    {
        return Tutorial::class;
    }

    public function render()
    {
        $comments = $this->getCommentsForRender();

        return view('livewire.tutorials.show', [
            'comments' => $comments,
        ])->layout('layouts.app', ['title' => $this->selectedTutorial->song->name . ' Tutorial']);
    }
}
