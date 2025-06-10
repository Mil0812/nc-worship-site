<header class="mb-[var(--spacing-lg)]">
    <div class="max-w-5xl mx-auto px-[var(--spacing-md)]">
        <div class="flex justify-between items-center mb-[var(--spacing-md)]">
            <div>
                <h2 class="text-[var(--font-size-xl)] font-[var(--font-weight-bold)]">{{ __('messages.settings') }}</h2>
                <p class="text-[var(--font-size-md)] mb-[var(--spacing-md)]">{{ __('messages.manage_profile') }}</p>
            </div>
            <a href="{{ url('/') }}" wire:navigate
               class="site-header__brand text-[var(--font-size-2xl)] font-[var(--font-weight-bold)] hover:text-[var(--color-primary-dark)] transition-[var(--transition-normal)]"
               aria-label="{{ __('messages.site_name') }} {{ __('messages.home') }}">
                {{ __('messages.site_name') }}
            </a>
        </div>
        <nav class="flex gap-[var(--spacing-sm)] border-b border-[var(--color-border)]">
            <a href="{{ route('dashboard') }}" wire:navigate
               class="pb-[var(--spacing-xs)] px-[var(--spacing-sm)] text-[var(--font-size-md)] font-[var(--font-weight-medium)] border-b-2 {{ Route::is('dashboard') ? 'border-[var(--color-primary)] text-[var(--color-primary)]' : 'border-transparent text-[var(--color-text-secondary)] hover:text-[var(--color-primary)] hover:border-[var(--color-primary)]' }} transition-[var(--transition-normal)]">
                {{ __('messages.main_settings') }}
            </a>
            <a href="{{ route('settings.password') }}" wire:navigate
               class="pb-[var(--spacing-xs)] px-[var(--spacing-sm)] text-[var(--font-size-md)] font-[var(--font-weight-medium)] border-b-2 {{ Route::is('settings.password') ? 'border-[var(--color-primary)] text-[var(--color-primary)]' : 'border-transparent text-[var(--color-text-secondary)] hover:text-[var(--color-primary)] hover:border-[var(--color-primary)]' }} transition-[var(--transition-normal)]">
                {{ __('messages.password') }}
            </a>
            <a href="{{ route('favourites') }}" wire:navigate
               class="pb-[var(--spacing-xs)] px-[var(--spacing-sm)] text-[var(--font-size-md)] font-[var(--font-weight-medium)] border-b-2 {{ Route::is('favourites') ? 'border-[var(--color-primary)] text-[var(--color-primary)]' : 'border-transparent text-[var(--color-text-secondary)] hover:text-[var(--color-primary)] hover:border-[var(--color-primary)]' }} transition-[var(--transition-normal)]">
                {{ __('messages.favourites') }}
            </a>
            <a href="{{ route('notifications') }}" wire:navigate
               class="pb-[var(--spacing-xs)] px-[var(--spacing-sm)] text-[var(--font-size-md)] font-[var(--font-weight-medium)] border-b-2 flex items-center {{ Route::is('notifications') ? 'border-[var(--color-primary)] text-[var(--color-primary)]' : 'border-transparent text-[var(--color-text-secondary)] hover:text-[var(--color-primary)] hover:border-[var(--color-primary)]' }} transition-[var(--transition-normal)]">
                {{ __('messages.notifications') }}
                <livewire:notification-counter/>
            </a>
        </nav>
    </div>
</header>
