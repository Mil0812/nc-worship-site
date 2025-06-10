{{-- The Master doesn't talk, he acts. --}}
<span wire:poll.60s>
    @if($unreadCount > 0)
        <span
            class="ml-1 inline-flex items-center px-2 py-1 text-xs font-bold leading-none text-[var(--color-text-primary
             bg-[var(--color-error)] rounded-full">
            {{ $unreadCount }}
        </span>
    @endif
</span>
