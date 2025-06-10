<section class="band" aria-labelledby="band-heading">
    <header class="show-page-header">
        <h1 id="band-heading">
            {{--            class="band__name text-center"--}}
            {{ $band->name }}
        </h1>
    </header>

    <div class="band__image max-w-[400px] mx-auto mb-[var(--spacing-xl)]">
        <img
            src="{{ $band->image_url }}"
            alt="{{ str_replace('{name}', $band->name, __('messages.band_image_alt')) }}"
            class="w-full h-auto object-cover aspect-[4/3] rounded-[var(--radius-md)]"
            loading="lazy">
    </div>

    <div class="band__members">
        <h2 class="band__members-title text-[var(--font-size-xl)] font-[var(--font-weight-semibold)] mb-[var(--spacing-md)]">
            {{ __('messages.members') }}
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-[var(--spacing-lg)]">
            @forelse ($band->users as $user)
                <article class="band__member">
                    <div class="band__member-avatar flex justify-center py-[var(--spacing-md)]">
                        @if($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}"
                                 alt="{{ $user->name }}'s avatar"
                                 class="w-20 h-20 rounded-full object-cover border-2 border-[var(--color-primary)]">
                        @else
                            <div
                                class="w-20 h-20 rounded-full bg-[var(--color-primary-light)] flex items-center justify-center text-[var(--font-size-xl)] font-[var(--font-weight-bold)]">
                                {{ mb_substr($user->name, 0, 1, 'UTF-8') }}{{ $user->last_name ? mb_substr($user->last_name, 0, 1, 'UTF-8') : '' }}
                            </div>
                        @endif
                    </div>
                    <div class="band__member-content p-[var(--spacing-md)]">
                        <h3 class="band__member-name text-[var(--font-size-lg)] font-[var(--font-weight-medium)]">
                            {{ $user->name }}
                        </h3>
                        <p class="band__member-instrument text-[var(--font-size-md)]">
                            {{ $user->instruments->pluck('name')->join(', ') ?: __('messages.no_instrument') }}
                        </p>
                    </div>
                </article>
            @empty
                <p class="band__members-empty text-[var(--color-text-primary)]">
                    {{ __('messages.no_members_found') }}
                </p>
            @endforelse
        </div>
    </div>
</section>
