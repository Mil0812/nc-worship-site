<?php

namespace App\Livewire\Songs;

use AllowDynamicProperties;
use App\Models\Comment;
use App\Models\Favourite;
use App\Models\Song;
use App\Models\Tutorial;
use App\HasComments;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

#[AllowDynamicProperties]
class Show extends Component
{
    use HasComments;

    public string $slug;
    public Song $song;
    public bool $hideLyrics = false;
    public bool $hideChords = false;
    public string $selectedKey;
    public array $transposedSections = [];
    public bool $isFavorite = false;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        $this->song = Song::query()
            ->where('slug', $slug)
            ->with(['tutorials' => fn($query) =>
            $query->where('is_public', true)->with('instrument'), 'songSections'])
            ->firstOrFail();
        $this->selectedKey = $this->song->original_key->value;
        $this->updateTransposedSections();

        $user = Auth::user();
        if ($user) {
            $this->isFavorite = Favourite::where('user_id', $user->id)
                ->where('song_id', $this->song->id)
                ->exists();
        }
    }

    public function toggleHideLyrics(): void
    {
        $this->hideLyrics = !$this->hideLyrics;
    }

    public function toggleHideChords(): void
    {
        $this->hideChords = !$this->hideChords;
    }

    public function toggleFavorite(): void
    {
        $user = Auth::user();
        if (!$user) {
            $this->dispatch('showError', message: __('messages.log_in_to_favorite'));
            return;
        }

        if ($this->isFavorite) {
            Favourite::where('user_id', $user->id)
                ->where('song_id', $this->song->id)
                ->delete();
            session();
        } else {
            Favourite::create([
                'user_id' => $user->id,
                'song_id' => $this->song->id,
            ]);
            session();
        }

        $this->isFavorite = !$this->isFavorite;
    }

    public function updatedSelectedKey(): void
    {
        $this->updateTransposedSections();
        $this->dispatch('$refresh');
    }

    private function transposeChord(string $chord, string $fromKey, string $toKey): string
    {
        $notes = [
            'C' => 0, 'C#' => 1, 'D' => 2, 'D#' => 3, 'E' => 4, 'F' => 5,
            'F#' => 6, 'G' => 7, 'G#' => 8, 'A' => 9, 'A#' => 10, 'H' => 11
        ];

        $noteNames = array_keys($notes);

        $pattern = '/^([A-G](#)?)(.*)$/';
        preg_match($pattern, $chord, $matches);

        if (empty($matches)) {
            return $chord;
        }

        $rootNote = $matches[1];
        $suffix = $matches[3] ?? '';

        $slashChord = '';
        if (str_contains($suffix, '/')) {
            $parts = explode('/', $suffix);
            $suffix = $parts[0] ?? '';
            $slashNote = $parts[1] ?? '';
            if ($slashNote) {
                $slashChord = '/' . $this->transposeChord($slashNote, $fromKey, $toKey);
            }
        }

        $fromValue = $notes[$fromKey] ?? 0;
        $toValue = $notes[$toKey] ?? 0;
        $rootValue = $notes[$rootNote] ?? 0;

        $distance = ($toValue - $fromValue + 12) % 12;

        $newRootValue = ($rootValue + $distance) % 12;
        $newRootNote = $noteNames[$newRootValue];

        return $newRootNote . $suffix . $slashChord;
    }

    public function getTransposedChords($chords): array
    {
        if (!$chords) {
            return [];
        }

        $lines = explode("\n", trim($chords));
        $transposedLines = [];

        foreach ($lines as $line) {
            if (trim($line)) {
                $chordsInLine = explode(' ', trim($line));
                $transposedChords = [];

                foreach ($chordsInLine as $chord) {
                    if (trim($chord)) {
                        $transposedChord = $this->transposeChord($chord, $this->song->original_key->value, $this->selectedKey);
                        $transposedChords[] = $transposedChord;
                    }
                }

                $transposedLines[] = implode(' ', $transposedChords);
            } else {
                $transposedLines[] = '';
            }
        }

        return $transposedLines;
    }

    private function updateTransposedSections(): void
    {
        $this->transposedSections = [];
        foreach ($this->song->songSections as $section) {
            $this->transposedSections[$section->id] = $this->getTransposedChords($section->chords);
        }
    }

    protected function getCommentableId(): string
    {
        return $this->song->id;
    }

    protected function getCommentableType(): string
    {
        return Song::class;
    }

    public function render()
    {
        $comments = $this->getCommentsForRender();

        return view('livewire.songs.show', [
            'comments' => $comments,
        ])->layout('layouts.app', ['title' => $this->song->name]);
    }
}
