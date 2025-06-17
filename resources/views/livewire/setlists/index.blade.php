<section class="setlists" aria-labelledby="setlists-heading">
    <header class="setlists__header">
        <h1 id="setlists-heading" class="section-header">
            {{ __('messages.setlists_title') }}
        </h1>
        <div class="section-filters">
            <div class="setlists__filter flex-1">
                <label for="band-filter" class="sr-only">{{ __('messages.filter_by_band') }}</label>
                <select
                    wire:model.live="bandFilter"
                    id="band-filter"
                    class="input-primary"
                    aria-label="{{ __('messages.filter_by_band') }}">
                    <option value="">{{ __('messages.all_bands') }}</option>
                    @foreach ($bands as $band)
                        <option value="{{ $band->id }}">{{ $band->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="setlists__sort flex items-center gap-[var(--spacing-sm)]">
                <label for="sort" class="sr-only">{{ __('messages.sort_by_date') }}</label>
                <button
                    wire:click="toggleSortDirection"
                    class="btn-primary"
                    aria-label="{{ __('messages.toggle_sort_by_date') }}">
                    {{ __('messages.sort_by_date') }} {{ $sortDirection === 'asc' ? '↑' : '↓' }}
                </button>
            </div>
        </div>
    </header>

    @if ($message ?? false)
        <div class="setlists__empty col-span-full text-center py-[var(--spacing-xl)]">
            <p class="text-[var(--font-size-lg)]">
                {{ $message }}
            </p>
        </div>
    @else
        <div class="section-lists">
            @forelse ($setlists as $setlist)
                <a href="{{ route('setlists.show', $setlist->id) }}" wire:navigate
                   aria-label="{{ __('messages.view_details_for') }} {{ $setlist->name }}">
                    <article class="setlist-card card-white">
                        <div class="setlist-card__content p-[var(--spacing-md)] text-left">
                            <h2 class="setlist-card__name">
                                {{ $setlist->name }}
                            </h2>
                            <p class="setlist-card__date text-[var(--font-size-md)]">
                                {{ $setlist->performed_at?->locale('uk')->format('d M Y') ?? __('messages.no_date') }}
                                ({{ $setlist->performed_at?->diffForHumans() ?? '' }})
                            </p>
                            <p class="setlist-card__band text-[var(--font-size-sm)]">
                                {{ $setlist->band->name }}
                            </p>
                            <p class="setlist-card__songs text-[var(--font-size-sm)]">
                                {{ str_replace('{count}', $setlist->songs_count, __('messages.songs_count')) }}
                            </p>
                        </div>
                    </article>
                </a>
            @empty
                <div class="setlists__empty col-span-full text-center py-[var(--spacing-xl)]">
                    <p class="text-[var(--font-size-lg)]">
                        {{ __('messages.no_setlists_found') }}
                    </p>
                </div>
            @endforelse
        </div>

        <div class="setlists__pagination mt-[var(--spacing-xl)]">
            {{ $setlists->links() }}
        </div>
    @endif
</section>
