<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('messages.auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('messages.auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}; ?>

<div
    class="flex flex-col gap-[var(--spacing-lg)] max-w-md mx-auto p-[var(--spacing-md)] bg-[var(--color-background-alt)] rounded-[var(--radius-md)] shadow-md">
    <div class="flex justify-center mb-[var(--spacing-md)]">
        <img src="{{ asset('favicon.ico') }}" alt="{{ __('messages.site_name') }} {{ __('messages.logo') }}"
             class="w-16 h-16"
             style="color: var(--color-primary);">
    </div>
    <div
        class="flex flex-col gap-[var(--spacing-lg)] max-w-md mx-auto p-[var(--spacing-md)] bg-[var(--color-background-alt)] rounded-[var(--radius-md)] shadow-md">
        <x-auth-header :title="__('messages.login_title')"
                       :description="__('messages.login_description')" class="text-center"/>


        <x-auth-session-status class="text-center text-[var(--color-text-secondary)]" :status="session('status')"/>

        <form wire:submit="login" class="flex flex-col gap-[var(--spacing-md)]">
            <!-- Email Address -->
            <flux:input
                wire:model="email"
                :label="__('messages.email_address')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
                class="w-full"
            />


            <div class="relative">
                <flux:input
                    wire:model="password"
                    :label="__('messages.password')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('messages.password')"
                    class="w-full"
                />

                @if (Route::has('password.request'))
                    <flux:link
                        class="absolute right-0 top-0 text-sm text-[var(--color-primary)] hover:text-[var(--color-primary-dark)] transition-[var(--transition-normal)]"
                        :href="route('password.request')" wire:navigate>
                        {{ __('messages.forgot_your_password') }}
                    </flux:link>
                @endif
            </div>


            <flux:checkbox wire:model="remember" :label="__('messages.remember_me')"
                           class="text-[var(--color-text-secondary)]"/>

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit"
                             class="w-full bg-[var(--color-primary)] text-[var(--color-text-light)] hover:bg-[var(--color-primary-dark)] transition-[var(--transition-normal)] rounded-[var(--radius-md)] py-[var(--spacing-sm)]">
                    {{ __('messages.log_in') }}
                </flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="text-center text-sm text-[var(--color-text-secondary)] dark:text-[var(--color-text-light)]">
                {{ __('messages.dont_have_account') }}
                <flux:link :href="route('register')" wire:navigate
                           class="text-[var(--color-primary)] hover:text-[var(--color-primary-dark)] transition-[var(--transition-normal)]">
                    {{ __('messages.sign_up') }}
                </flux:link>
            </div>
        @endif
    </div>
</div>
