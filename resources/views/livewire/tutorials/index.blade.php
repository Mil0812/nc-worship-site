<section class="tutorials" aria-labelledby="tutorials-heading">
    <header class="tutorials__header">
        <h1 id="tutorials-heading" class="section-header">
            {{ __('messages.tutorials_title') }}
        </h1>

        <div class="section-filters">
            <div class="tutorials__search relative flex-1">
                <label for="search" class="sr-only">{{ __('messages.search_tutorials') }}</label>
                <input
                    wire:model.live.debounce.500ms="search"
                    id="search"
                    type="text"
                    placeholder="{{ __('messages.search_tutorials_placeholder') }}"
                    class="minimal-input h-9"
                    aria-label="{{ __('messages.search_tutorials') }}">
                <img
                    src="{{ asset('icons/search.png') }}"
                    alt="{{ __('messages.search_icon') }}"
                    class="absolute left-[var(--spacing-sm)] top-1/2 transform -translate-y-1/2 w-5 h-5"/>
                @if($search)
                    <button
                        wire:click="$set('search', '')"
                        class="absolute right-[var(--spacing-sm)] top-1/2 transform -translate-y-1/2 text-[var(--color-text-secondary)] hover:text-[var(--color-primary)] cursor-pointer"
                        aria-label="{{ __('messages.clear_search') }}">
                        ✕
                    </button>
                @endif
            </div>

            <div class="tutorials__filter">
                <label for="instrument-filter" class="sr-only">{{ __('messages.filter_by_instrument') }}</label>
                <select
                    wire:model.live="instrumentFilter"
                    id="instrument-filter"
                    class="input-primary"
                    aria-label="{{ __('messages.filter_by_instrument') }}">
                    <option value="">{{ __('messages.all_instruments') }}</option>
                    @foreach ($instruments as $instrument)
                        <option value="{{ $instrument->name }}">{{ $instrument->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </header>

    <div class="section-lists">
        @forelse ($songs as $song)
            @if($song->tutorials->where('is_public', true)->first())
                <a href="{{ route('tutorials.show', $song->tutorials->where('is_public', true)->first()->slug) }}"
                   wire:navigate
                   aria-label="{{ __('messages.view_details_for') }} {{ $song->name }}">
                    <div class="tutorial-group">
                        <div
                            class="tutorial-group__song flex items-center gap-[var(--spacing-md)] p-[var(--spacing-md)]">
                            <div class="tutorial-group__song-image w-[100px] aspect-[4/3]">
                                <img
                                    src="{{ $song->image_url }}"
                                    alt="{{ str_replace('{song_name}', $song->name, __('messages.song_image_alt')) }}"
                                    class="w-full h-full object-cover rounded-[var(--radius-md)]"
                                    loading="lazy">
                            </div>
                            <div>
                                <h2 class="tutorial-group__song-title text-[var(--font-size-xl)] font-[var(--font-weight-semibold)]">
                                    {{ $song->name }}
                                </h2>
                                <div
                                    class="tutorial-group__instruments flex gap-[var(--spacing-sm)] mt-[var(--spacing-sm)]">
                                    @foreach ($song->tutorials as $tutorial)
                                        @if ($tutorial->instrument && $tutorial->is_public)
                                            <div class="tutorial-group__instrument">
                                                <img
                                                    src="{{ $tutorial->instrument->icon_url}}"
                                                    alt="{{ str_replace('{instrument_name}', $tutorial->instrument->name, __('messages.instrument_icon_alt')) }}"
                                                    class="tutorial-group__instrument-icon w-[24px] h-[24px]"
                                                    loading="lazy">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endif
        @empty
            <div class="tutorials__empty col-span-full text-center py-[var(--spacing-xl)]">
                <p class="text-[var(--font-size-lg)]">
                    {{ __('messages.no_tutorials_found') }}
                </p>
            </div>
        @endforelse
    </div>
</section>
