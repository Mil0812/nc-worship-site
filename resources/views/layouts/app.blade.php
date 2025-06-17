<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="{{ __('messages.site_name') }} - Christian music platform for bands, songs, and tutorials">
    <title>{{ __('messages.site_name') }} - {{$title ?? __('messages.home')}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap"
          rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="flex flex-col min-h-screen"
      style="background: linear-gradient(30deg, #2D3E55 0%, #2E4055 6%, #2d4e71 14%, #376c8c 15%, #24354C 16%, #29334F 31%, #1F3852 44%, #0A567E 57%, #569D8B 71%, #408BA4 78%, #2B496E 100%)">
<a href="#main-content"
   class="sr-only focus:not-sr-only focus:absolute focus:p-[var(--spacing-sm)] focus:bg-[var(--color-primary)] focus:text-[var(--color-text-light)] focus:rounded-[var(--radius-md)]">
    {{ __('messages.skip_to_main_content') }}
</a>

<header
    class="site-header bg-[rgba(31,56,82,0.9)] border-b border-[var(--color-border)] sticky top-0 z-50 transition-all duration-300 ease-in-out"
    id="site-header">
    <div
        class="site-header__inner max-w-[var(--container-max-width)] mx-auto px-[var(--spacing-md)] flex items-center justify-between py-[var(--spacing-md)]">
        <a href="{{ url('/') }}" wire:navigate
           class="site-header__brand font-[var(--font-weight-bold)] text-[var(--color-text-light)]"
           aria-label="{{ __('messages.site_name') }} {{ __('messages.home') }}">
            {{ __('messages.site_name') }}
        </a>

        <div class="site-header__nav-container flex items-center w-full justify-center">
            <nav class="site-header__nav" aria-label="{{ __('messages.main_navigation') }}">
                <ul class="site-header__nav-list flex gap-[var(--spacing-lg)]">
                    <li>
                        <a href="{{ route('bands.index') }}" wire:navigate
                           class="site-header__nav-link font-[var(--font-weight-medium)] text-[var(--color-text-primary)] hover:text-[var(--color-primary-light)] transition-[var(--transition-normal)]
                           {{ Route::is('bands.index') ? 'text-[var(--color-primary)]' : '' }}"
                           aria-current="{{ Route::is('bands.index') ? 'page' : 'false' }}">
                            {{ __('messages.bands') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('songs.index') }}" wire:navigate
                           class="site-header__nav-link font-[var(--font-weight-medium)] text-[var(--color-text-primary)] hover:text-[var(--color-primary-light)]  transition-[var(--transition-normal)] {{ Route::is('songs.index') ? 'text-[var(--color-primary)]' : '' }}"
                           aria-current="{{ Route::is('songs.index') ? 'page' : 'false' }}">
                            {{ __('messages.songs') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tutorials.index') }}" wire:navigate
                           class="site-header__nav-link font-[var(--font-weight-medium)] text-[var(--color-text-primary)] hover:text-[var(--color-primary-light)]  transition-[var(--transition-normal)] {{ Route::is('tutorials.index') ? 'text-[var(--color-primary)]' : '' }}"
                           aria-current="{{ Route::is('tutorials.index') ? 'page' : 'false' }}">
                            {{ __('messages.tutorials') }}
                        </a>
                    </li>
                    @if (Auth::check() && Auth::user()->isGroupMember())
                        <li>
                            <a href="{{ route('setlists.index') }}" wire:navigate
                               class="site-header__nav-link site-header__setlists flex items-center gap-[var(--spacing-xs)] font-[var(--font-weight-medium)] text-[var(--color-text-primary)] hover:text-[var(--color-primary-light)] transition-[var(--transition-normal)]
                               {{ Route::is('setlists.index') ? 'text-[var(--color-primary)]' : '' }}"
                               title="{{ __('messages.setlists') }}"
                               aria-label="{{ __('messages.navigate_to_setlists') }}"
                               aria-current="{{ Route::is('setlists.index') ? 'page' : 'false' }}">
                                {{ __('messages.setlists') }}
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>

        <div class="site-header__auth flex items-center gap-[var(--spacing-md)]">
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="site-header__nav-link"
                       title="{{ __('messages.dashboard') }}" aria-label="{{ __('messages.dashboard') }}">
                        <img src="{{ asset('icons/account.png') }}" alt="{{ __('messages.dashboard') }}"
                             class="h-9 w-9">
                    </a>
                    @livewire('logout-button')
                @else
                    <a href="{{ route('login') }}"
                       class="site-header__nav-link text-[var(--color-primary-dark)] bg-[var(--color-text-primary)] border border-[var(--color-text-primary)] hover:bg-[var(--color-primary-light)] hover:text-[var(--color-text-primary)] rounded-sm text-sm leading-normal transition-[var(--transition-normal)] px-4 py-2">
                        {{ __('messages.login') }}
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="site-header__nav-link text-[var(--color-text-primary)] dark:text-[var(--color-text-light)] border border-[var(--color-border)] hover:border-[var(--color-primary)] rounded-sm text-sm leading-normal transition-[var(--transition-normal)]  px-4 py-2">
                            {{ __('messages.register') }}
                        </a>
                    @endif
                @endauth
            @endif
        </div>

    </div>
</header>

<main id="main-content"
      class="site-main flex-1 max-w-[var(--container-max-width)] mx-auto px-[var(--container-padding)] py-[var(--spacing-xl)]">
    {{ $slot }}
</main>

<footer class="footer bg-[var(--color-background-dark)]">
    <div class="site-footer__inner max-w-[var(--container-max-width)] mx-auto px-[var(--container-padding)]">
        <p class="text-[var(--font-size-sm)] text-center">
            {{ str_replace('{year}', date('Y'), __('messages.footer_copyright')) }}
        </p>
    </div>
</footer>

@livewireScripts
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const header = document.getElementById('site-header');
        let lastScroll = 0;

        window.addEventListener('scroll', function () {
            let currentScroll = window.pageYOffset || document.documentElement.scrollTop;

            if (currentScroll > 10) {
                header.style.backgroundColor = 'rgba(31, 56, 82, 0.95)';
            } else {
                header.style.backgroundColor = 'rgba(31, 56, 82, 0.4)';
            }

            lastScroll = currentScroll;
        });
    });
</script>

<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
