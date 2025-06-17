@php use App\Enums\OriginalKey; @endphp
<section class="song" aria-labelledby="song-heading">
    <header class="show-page-header">
        <h1 id="song-heading" class="song__title title-primary text-center">
            {{ $song->name }}
        </h1>
    </header>

    <div class="song__content flex flex-col lg:flex-row gap-[var(--spacing-xl)]">

        <aside class="song__sidebar w-full lg:w-1/4">
            <div class="song__info song-info-box">
                @if($song->author)
                    <div class="song__info-item">
                        <span class="font-[var(--font-weight-semibold)]">{{ __('messages.author_label') }}:</span>
                        <span>{{ $song->author }}</span>
                    </div>
                @endif
                <div class="song__info-item">
                    <span class="font-[var(--font-weight-semibold)]">{{ __('messages.bpm_label') }}:</span>
                    <span>{{ $song->bpm }}</span>
                </div>
                @if($song->time_signature)
                    <div class="song__info-item">
                        <span
                            class="font-[var(--font-weight-semibold)]">{{ __('messages.time_signature_full_label') }}:</span>
                        <span>{{ $song->time_signature }}</span>
                    </div>
                @endif
                <div class="song__info-item">
                    <span class="font-[var(--font-weight-semibold)]">{{ __('messages.original_key_label') }}:</span>
                    <span>{{ $song->original_key }}</span>
                </div>
            </div>
        </aside>

        <div class="song__main flex-1">
            @if($song->audio_url)
                <div class="song__audio mb-[var(--spacing-xl)]">
                    <div class="custom-audio-player">
                        <audio controls class="custom-audio w-full">
                            <source src="{{ $song->audio_url }}" type="audio/mpeg">
                            {{ __('messages.audio_not_supported') }}
                        </audio>
                    </div>
                </div>
            @endif

            @if($song->songSections->isNotEmpty())
                <div class="song__controls flex gap-4 mb-4 items-center justify-between">
                    <select wire:model.live="selectedKey"
                            class="border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 cursor-pointer"
                            id="select-key"
                            aria-label="{{ __('messages.select_key') }}">
                        @foreach (OriginalKey::cases() as $key)
                            <option value="{{ $key->value }}">{{ $key->getLabel() }}</option>
                        @endforeach
                    </select>
                    <button wire:click="toggleHideLyrics" class="focus:outline-none hover:opacity-80"
                            aria-label="{{ __('messages.toggle_lyrics_visibility') }}">
                        <img src="{{ asset('images/' . ($hideLyrics ? 'show-lyrics.png' : 'hide-lyrics.png')) }}"
                             alt="{{ $hideLyrics ? __('messages.show_lyrics') : __('messages.hide_lyrics') }}"
                             class="w-8 h-8">
                    </button>
                    <button wire:click="toggleHideChords" class="focus:outline-none hover:opacity-80"
                            aria-label="{{ __('messages.toggle_chords_visibility') }}">
                        <img src="{{ asset('images/' . ($hideChords ? 'show-chords.png' : 'hide-chords.png')) }}"
                             alt="{{ $hideChords ? __('messages.show_chords') : __('messages.hide_chords') }}"
                             class="w-8 h-8">
                    </button>
                    <button wire:click="toggleFavorite"
                            class="mt-4 focus:outline-none hover:opacity-80 cursor-pointer ml-auto">
                        <svg
                            class="w-8 h-8 {{ $isFavorite ? 'fill-[var(--color-like)]' : 'fill-[var(--color-text-secondary)]' }}"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        <span
                            class="sr-only">{{ $isFavorite ? __('messages.remove_from_favorites') : __('messages.add_to_favorites') }}</span>
                    </button>
                </div>
                <div class="song__lyrics">
                    @foreach($song->songSections as $section)
                        <div
                            class="song__structure {{ 'song__' . strtolower(str_replace('_', '-', $section->section_type->value)) }} song-section-box">
                            <h2 class="song-section-title">
                                {{ strtoupper($section->section_type->getLabel()) }}
                            </h2>
                            @php
                                $lyricsLines = explode("\n", trim($section->lyrics));
                                $chordsLines = $transposedSections[$section->id] ?? array_fill(0, count($lyricsLines), '');
                            @endphp
                            @foreach(array_map(null, $chordsLines, $lyricsLines) as $index => [$chords, $lyrics])
                                <div class="song__chords flex flex-col items-start">
                                    @if(trim($chords) && !$hideChords)
                                        <span class="text-[var(--font-size-md)] font-[var(--font-weight-semibold)]">
                                            {{ trim($chords) }}
                                        </span>
                                    @endif
                                    @if(trim($lyrics) && !$hideLyrics)
                                        <span class="text-[var(--font-size-md)]">
                                            {{ trim($lyrics) ?: ' ' }}
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <x-comments-section :comments="$comments" :component="$this"/>

    <script>
        Livewire.on('showSuccess', ({message}) => {
            Swal.fire({
                icon: 'success',
                title: '{{ __('messages.js_success_title') }}',
                text: message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'bg-[var(--color-success-light)] text-[var(--color-text-primary)]',
                }
            });
        });

        Livewire.on('showError', ({message}) => {
            Swal.fire({
                icon: 'error',
                title: '{{ __('messages.js_error_title') }}',
                text: message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'bg-[var(--color-error-light)] text-[var(--color-text-primary)]',
                }
            });
        });

        Livewire.on('confirmCommentDeletion', ({commentId}) => {
            Swal.fire({
                title: '{{ __("messages.are_you_sure") }}',
                text: '{{ __("messages.delete_comment_confirmation") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--color-error)',
                cancelButtonColor: 'var(--color-text-secondary)',
                confirmButtonText: '{{ __("messages.yes_delete") }}',
                cancelButtonText: '{{ __("messages.cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.
                    deleteComment(commentId);
                }
            });
        });
    </script>
</section>
