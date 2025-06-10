<section class="setlist" aria-labelledby="setlist-heading">
    <header class="setlist__header">
        <h1 id="setlist-heading"
            class="setlist__name text-center text-[var(--color-text-primary)] font-[var(--font-weight-bold)]">
            {{ $setlist->name }}
        </h1>
        <div class="setlist__date text-center text-[var(--font-size-md)]">
            {{ $setlist->performed_at?->format('M d, Y') ?? __('messages.no_date') }}
        </div>
        <div class="setlist__band text-center text-[var(--font-size-sm)]">
            {{ __('messages.band') }}: {{ $setlist->band->name }}
        </div>
        <div class="setlist__actions flex justify-center gap-[var(--spacing-sm)] mt-[var(--spacing-md)]">
            <button wire:click="toggleSortDirection" class="btn-primary"
                    aria-label="{{ __('messages.toggle_song_order') }}">
                {{ __('messages.song_order') }} {{ $sortDirection === 'asc' ? '↑' : '↓' }}
            </button>
        </div>
    </header>

    <div class="setlist__table mt-[var(--spacing-xl)]">
        <div class="setlist-table-card">
            <table class="w-full text-left">
                <thead>
                <tr>
                    <th class="setlist__song-number p-[var(--spacing-sm)] border-b text-[var(--color-text-primary)]">{{ __('messages.song_number') }}</th>
                    <th class="setlist__song-title p-[var(--spacing-sm)] border-b text-[var(--color-text-primary)]">{{ __('messages.song_title') }}</th>
                    <th class="setlist__song-key p-[var(--spacing-sm)] border-b text-[var(--color-text-primary)]">{{ __('messages.song_key') }}</th>
                    <th class="setlist__song-leader p-[var(--spacing-sm)] border-b text-[var(--color-text-primary)]">{{ __('messages.song_leader') }}</th>
                    <th class="setlist__song-pad p-[var(--spacing-sm)] border-b text-[var(--color-text-primary)]">{{ __('messages.song_pad') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($songs as $setlistSong)
                    <tr class="setlist__song border-b">
                        <td class="setlist__song-number setlist-cell">{{ $setlistSong->number }}</td>
                        <td class="setlist__song-title setlist-cell">
                            <a href="{{ route('songs.show', $setlistSong->song->slug) }}" wire:navigate>
                                {{ $setlistSong->song->name }}
                            </a>
                        </td>
                        <td class="setlist__song-key setlist-cell">{{ $setlistSong->key->value }}</td>
                        <td class="setlist__song-leader setlist-cell">{{ $setlistSong->leader?->name ?? __('messages.na') }}</td>
                        <td class="setlist__song-pad setlist-cell">
                            @if($setlistSong->pad && $setlistSong->pad->audio_url)
                                <div class="flex items-center">
                                    @if($currentlyPlayingPadId === $setlistSong->pad->id)
                                        <button wire:click="stopPad"
                                                class="pad-control bg-[var(--color-primary)] text-white p-1 rounded-full mr-2 hover:bg-[var(--color-primary-dark)] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <rect x="6" y="6" width="8" height="8"/>
                                            </svg>
                                        </button>
                                    @else
                                        <button wire:click="playPad('{{ $setlistSong->pad->id }}')"
                                                class="pad-control bg-[var(--color-primary)] text-white p-1 rounded-full mr-2 hover:bg-[var(--color-primary-dark)] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    @endif
                                    <span>{{ __('messages.pad_available') }}</span>
                                </div>
                            @else
                                {{ __('messages.na') }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-[var(--spacing-sm)] text-center text-[var(--color-text-primary)]">
                            {{ __('messages.no_songs_in_setlist') }}
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @foreach ($songs as $setlistSong)
        @if($setlistSong->pad && $setlistSong->pad->audio_url)
            <audio id="pad-{{ $setlistSong->pad->id }}" preload="none" class="hidden">
                <source src="{{ Storage::url($setlistSong->pad->audio) }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        @endif
    @endforeach

    <script>
        document.addEventListener('livewire:initialized', () => {
            let currentAudio = null;

            Livewire.on('play-pad', (data) => {
                const {padId} = data;
                if (currentAudio) {
                    currentAudio.pause();
                    currentAudio.currentTime = 0;
                }

                const audio = document.getElementById(`pad-${padId}`);
                if (audio) {
                    audio.play().then(() => {
                        currentAudio = audio;
                    }).catch(error => {
                        Livewire.dispatch('showError', {message: 'Failed to play audio: ' + error.message});
                    });

                    audio.onended = () => {
                        Livewire.dispatch('stopPad');
                        currentAudio = null;
                    };
                } else {
                    Livewire.dispatch('showError', {message: 'Audio element not found'});
                }
            });

            Livewire.on('stop-pad', () => {
                if (currentAudio) {
                    currentAudio.pause();
                    currentAudio.currentTime = 0;
                    currentAudio = null;
                }
            });

            Livewire.on('showError', ({message}) => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('messages.error') }}',
                        text: message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                } else {
                    alert(message);
                }
            });
        });
    </script>
</section>
