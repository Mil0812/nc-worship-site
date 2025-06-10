<section class="home" aria-labelledby="home-about-title">
    <div class="header-image">
        <img src="{{ asset('images/home-image.png') }}" alt="Header Image"
             class="w-full h-auto object-cover">
    </div>
    <section class="home__about">
        <h1 class="home__about-title title-primary" id="home-about-title">
            {{ __('messages.about_us_title') }}
        </h1>
        <div class="home__about-content">
            <p class="home__about-content__text text-[var(--font-size-lg)]">
                {{ __('messages.about_us_content') }}
            </p>
        </div>
    </section>


    <section class="home__latest-songs" aria-labelledby="home-latest-songs-title">
        <h2 class="home__latest-songs__title title-primary" id="home-latest-songs-title">
            {{ __('messages.latest_songs_title') }}
        </h2>
        <div class="home__latest-songs__grid">
            @forelse ($songs as $song)
                <a href="{{ route('songs.show', $song->slug)}}" wire:navigate
                   aria-label="{{ __('messages.view_details_for') }} {{ $song->name }}">
                    <article class="song-card">
                        <div class="song-card__image">
                            <img
                                src="{{ $song->image ? Storage::url($song->image) : asset('default-images/example-song-image.png') }}"
                                alt="{{ $song->name }} song image" class="w-full h-full object-cover" loading="lazy">
                        </div>
                        <div class="song-card__content">
                            <h2 class="song-card__title">
                                {{ $song->name }}
                            </h2>
                            <p class="song-card__author">
                                {{ $song->author ?? __('messages.unknown') }}
                            </p>
                        </div>
                    </article>
                </a>
            @empty
                <div class="songs__empty col-span-full text-center py-[var(--spacing-xl)]">
                    <p class="text-[var(--font-size-lg)]">
                        {{ __('messages.no_songs_found') }}
                    </p>
                </div>
            @endforelse
        </div>
    </section>
</section>
