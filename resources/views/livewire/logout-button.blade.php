<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <button
        wire:click="logout"
        class="site-header__nav-link text-[var(--color-text-primary)] cursor-pointer"
        title="{{__('messages.logout')}}"
        aria-label="{{__('messages.logout')}}">
        <img src="{{ asset('icons/logout.png') }}" alt="{{__('messages.logout')}}" class="h-9 w-9">
    </button>
</div>
