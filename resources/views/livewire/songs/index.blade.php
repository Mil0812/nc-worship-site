{{-- Close your eyes. Count to one. That is how long forever feels. --}}
<section class="songs" aria-labelledby="songs-heading">
    <header class="songs__header">
        <h1 id="songs-heading" class="section-header">
            {{ __('messages.songs_title') }}
        </h1>

        <div
            class="section-filters ">
            <div class="songs__search relative">
                <label for="search" class="sr-only">{{ __('messages.search_songs') }}</label>
                <input
                    wire:model.live.debounce.500ms="search"
                    id="search"
                    type="text"
                    placeholder="{{ __('messages.search_songs_placeholder') }}"
                    class="minimal-input h-9"
                    aria-label="{{ __('messages.search_songs') }}">
                <img
                    src="{{ asset('icons/search.png') }}"
                    alt="{{ __('messages.search_icon') }}"
                    class="absolute left-[var(--spacing-sm)] top-1/2 transform -translate-y-1/2 w-5 h-5 "/>

                @if($search)
                    <button
                        wire:click="$set('search', '')"
                        class="absolute right-[var(--spacing-sm)] top-1/2 transform -translate-y-1/2 text-[var(--color-text-secondary)] hover:text-[var(--color-primary)] cursor-pointer"
                        aria-label="{{ __('messages.clear_search') }}">
                        ✕
                    </button>
                @endif
            </div>

            <div class="songs__filter">
                <label for="type-filter" class="sr-only">{{ __('messages.filter_by_song_type') }}</label>
                <select
                    wire:model.live="typeFilter"
                    id="type-filter"
                    class="input-primary"
                    aria-label="{{ __('messages.filter_by_song_type') }}">
                    <option value="">{{ __('messages.all_types') }}</option>
                    @foreach ($songTypes as $type)
                        <option value="{{ $type->value }}">{{ $type->getLabel() }}</option>
                    @endforeach
                </select>
            </div>

            <div class="songs__sort flex items-center gap-[var(--spacing-sm)]">
                <label for="sort" class="sr-only">{{ __('messages.sort_songs') }}</label>
                <select
                    wire:model.live="sortBy"
                    id="sort"
                    class="input-primary"
                    aria-label="{{ __('messages.sort_songs') }}">
                    <option value="name">{{ __('messages.sort_by_name_option') }}</option>
                    <option value="created_at">{{ __('messages.sort_by_date_added') }}</option>
                </select>
                <button
                    wire:click="toggleSortDirection"
                    class="btn-primary transition-[var(--transition-normal)] cursor-pointer"
                    aria-label="{{ __('messages.toggle_sort_direction_songs') }}">
                    {{ $sortDirection === 'asc' ? '↑' : '↓' }}
                </button>
            </div>
        </div>
    </header>

    <div class="section-lists">
        @foreach($songs as $song)
            <a href="{{ route('songs.show', $song->slug)}}" wire:navigate
               aria-label="{{ __('messages.view_details_for') }} {{ $song->name }}">
                <article class="song-card" aria-labelledby="song-{{ $song->id }}-title">
                    <img
                        class="song-card__image w-full h-auto aspect-[4/3] object-cover"
                        src="{{ $song->image_url }}"
                        alt="{{ str_replace('{song_name}', $song->name, __('messages.song_cover_alt')) }}"
                        loading="lazy">
                    <div class="song-card__content p-[var(--spacing-sm)] card-text">
                        <h3 class="song-card__title text-[var(--font-size-md)] font-[var(--font-weight-semibold)] truncate"
                            id="song-{{ $song->id }}-title">
                            {{ $song->name }}
                        </h3>
                        @if($song->author)
                            <p class="song-card__author text-[var(--font-size-xs)] truncate">
                                {{ str_replace('{author}', $song->author, __('messages.by_author')) }}
                            </p>
                        @endif
                        <p class="song-card__meta text-[var(--font-size-xs)]">
                            {{ __('messages.key_label') }}: {{ $song->original_key }} |
                            {{ __('messages.bpm_label') }}: {{ $song->bpm }} |
                            @if($song->time_signature)
                                {{ __('messages.time_signature_label') }}: {{ $song->time_signature }}
                            @endif
                        </p>
                    </div>
                </article>
            </a>
        @endforeach
    </div>

    <div class="songs__pagination mt-[var(--spacing-xl)] text-center">
        {{ $songs->links() }}
    </div>
</section>
