<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $last_name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div
    class="flex flex-col gap-[var(--spacing-lg)] max-w-md mx-auto p-[var(--spacing-md)] bg-[var(--color-background-alt)] rounded-[var(--radius-md)] shadow-md">
    <div class="flex justify-center mb-[var(--spacing-md)]">
        <img src="{{ asset('favicon.ico') }}" alt="{{ __('messages.site_name') }} {{ __('messages.logo') }}"
             class="w-16 h-16"
             style="color: var(--color-primary);">
    </div>
    <x-auth-header :title="__('messages.create_account_title')" :description="__('messages.create_account_description')"
                   class="text-center"/>

    <!-- Session Status -->
    <x-auth-session-status class="text-center text-[var(--color-text-secondary)]" :status="session('status')"/>

    <form wire:submit="register" class="flex flex-col gap-[var(--spacing-md)]">
        <!-- First Name -->
        <flux:input
            wire:model="name"
            :label="__('messages.first_name')"
            type="text"
            required
            autofocus
            autocomplete="given-name"
            :placeholder="__('messages.first_name')"
            class="w-full"
        />

        <!-- Last Name -->
        <flux:input
            wire:model="last_name"
            :label="__('messages.last_name')"
            type="text"
            required
            autocomplete="family-name"
            :placeholder="__('messages.last_name')"
            class="w-full"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('messages.email_address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
            class="w-full"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('messages.password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('messages.password')"
            class="w-full"
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('messages.confirm_password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('messages.confirm_password')"
            class="w-full"
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary"
                         class="w-full bg-[var(--color-primary)] text-[var(--color-text-light)] hover:bg-[var(--color-primary-dark)] transition-[var(--transition-normal)] rounded-[var(--radius-md)] py-[var(--spacing-sm)]">
                {{ __('messages.create_account') }}
            </flux:button>
        </div>
    </form>

    <div class="text-center text-sm text-[var(--color-text-secondary)] dark:text-[var(--color-text-light)]">
        {{ __('messages.already_have_account') }}
        <flux:link :href="route('login')" wire:navigate
                   class="text-[var(--color-primary)] hover:text-[var(--color-primary-dark)] transition-[var(--transition-normal)]">
            {{ __('messages.log_in') }}
        </flux:link>
    </div>
</div>
