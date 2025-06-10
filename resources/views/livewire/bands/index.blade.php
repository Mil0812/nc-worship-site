<section class="bands" aria-labelledby="bands-heading">
    <header class="bands__header">
        <h1 id="bands-heading" class="section-header">
            {{ __('messages.music_bands') }}
        </h1>

        <div class="section-filters">
            <div class="bands__search relative">
                <label for="search" class="sr-only">{{ __('messages.search_bands') }}</label>
                <input
                    wire:model.live.debounce.500ms="search"
                    id="search"
                    type="text"
                    placeholder="{{ __('messages.search_bands_placeholder') }}"
                    class="minimal-input h-9"
                    aria-label="{{ __('messages.search_bands') }}">
                <img
                    src="{{ asset('icons/search.png') }}"
                    alt="{{ __('messages.search_icon') }}"
                    class="absolute left-[var(--spacing-sm)] top-1/2 transform -translate-y-1/2 w-5 h-5"/>

                @if($search)
                    <button
                        wire:click="$set('search', '')"
                        class="absolute right-[var(--spacing-sm)] top-1/2 transform -translate-y-1/2 text-[var(--color-text-secondary)]"
                        aria-label="{{ __('messages.clear_search') }}">
                        ✕
                    </button>
                @endif
            </div>

            <div class="bands__sort flex items-center gap-[var(--spacing-sm)]">
                <button
                    wire:click="toggleSortDirection"
                    class="btn-primary"
                    aria-label="{{ __('messages.toggle_sort_direction') }}">
                    {{ $sortDirection === 'asc' ? '↑' : '↓' }}
                </button>
            </div>
        </div>
    </header>

    <div class="section-lists">
        @forelse ($bands as $band)
            <a href="{{ route('bands.show', $band->id) }}" wire:navigate
               aria-label="{{ __('messages.view_details_for') }} {{ $band->name }}">
                <article class="band-card">
                    <div
                        class="band-card aspect-[4/3] relative">
                        <img
                            src="{{ $band->image_url}}"
                            alt="{{ str_replace('{name}', $band->name, __('messages.band_image_alt')) }}"
                            class="band__image w-full h-full object-cover rounded-[var(--radius-md)]"
                            loading="lazy">
                        <div class="band-card__content absolute inset-0 flex items-center justify-center">
                            <h2 class="band-card__name text-[var(--font-size-xl)] font-[var(--font-weight-semibold)] truncate">
                                {{ $band->name }}
                            </h2>
                        </div>
                    </div>
                </article>
            </a>
        @empty
            <div class="bands__empty col-span-full text-center py-[var(--spacing-xl)]">
                <p class="text-[var(--font-size-lg)]">
                    {{ __('messages.no_bands_found') }}
                </p>
            </div>
        @endforelse
    </div>

    <div class="bands__pagination mt-[var(--spacing-xl)] text-center">
        {{ $bands->links() }}
    </div>
</section>
