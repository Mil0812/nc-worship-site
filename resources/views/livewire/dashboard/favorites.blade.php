{{-- Close your eyes. Count to one. That is how long forever feels. --}}
<div
    class="favorites w-full max-w-5xl mx-auto p-[var(--spacing-md)]  rounded-[var(--radius-md)] shadow-[var(--shadow-md)]">
    <div class="favorites__header mb-[var(--spacing-md)] text-center">
        <h3 class="text-[var(--font-size-lg)] font-[var(--font-weight-bold)]">{{ __('messages.favourite_songs') }}</h3>
        <p class="text-[var(--font-size-md)]">{{ __('messages.your_favorite_songs') }}</p>
    </div>

    <div class="favorites__sort flex gap-4 mb-4 justify-center">
        <button wire:click="sort('name')"
                class="text-[var(--color-secondary)] hover:text-[var(--color-secondary-dark)]">
            {{ __('messages.sort_by_name') }} {{ $sortBy === 'name' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}
        </button>
        <button wire:click="sort('author')"
                class="text-[var(--color-secondary)] hover:text-[var(--color-secondary-dark)]">
            {{ __('messages.sort_by_author') }} {{ $sortBy === 'author' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}
        </button>
    </div>

    <div class="favorites__list space-y-4">
        @forelse ($favorites as $song)
            <div
                class="favorite-card flex items-center gap-4 p-4 rounded-[var(--radius-md)] shadow-[var(--shadow-md)]">
                <div class="favorite-card__image">
                    @if ($song->image_url)
                        <img src="{{ $song->image_url }}" alt="{{ $song->name }} cover"
                             class="w-16 h-16 rounded-md object-cover">
                    @else
                        <div
                            class="w-16 h-16 bg-[var(--color-background-alt)] rounded-md flex items-center justify-center text-[var(--color-text-secondary)]">
                            🎵
                        </div>
                    @endif
                </div>
                <div class="favorite-card__title flex-1">
                    <a href="{{ route('songs.show', $song->slug) }}" wire:navigate
                       class="text-[var(--font-size-md)] font-[var(--font-weight-semibold)] hover:text-[var(--color-primary-dark)]">
                        {{ $song->name }}
                    </a>
                </div>
                <div class="favorite-card__author text-[var(--font-size-md)]">
                    {{ $song->author ?? __('messages.unknown') }}
                </div>
                <button wire:click="removeFromFavorites('{{ $song->id }}')"
                        class="favorite-card__remove text-[var(--color-error)] hover:text-[var(--color-error-dark)]">
                    {{ __('messages.remove') }}
                </button>
            </div>
        @empty
            <p class="text-[var(--color-text-secondary)] text-center">{{ __('messages.no_favorite_songs') }}</p>
        @endforelse
    </div>

    @if (session('status'))
        <p class="text-[var(--color-success)] mt-4 text-center">{{ session('status') }}</p>
    @endif
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('customShowSuccess', ({message}) => {
            Swal.fire({
                icon: 'success',
                title: '{{ __('messages.success') }}',
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
    });
</script>
